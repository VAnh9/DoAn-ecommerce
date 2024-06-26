<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CanceledOrderDataTable;
use App\DataTables\DeliveredOrderDataTable;
use App\DataTables\DroppedOffOrderDataTable;
use App\DataTables\OrderDataTable;
use App\DataTables\OutForDeliveryOrderDataTable;
use App\DataTables\PendingOrderDataTable;
use App\DataTables\ProcessedOrderDataTable;
use App\DataTables\ShippedOrderDataTable;
use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(OrderDataTable $dataTable)
  {
    return $dataTable->render('admin.order.index');
  }

  /** display all pending orders */
  public function getPendingOrders(PendingOrderDataTable $dataTable)
  {
    return $dataTable->render('admin.order.pending-order');
  }

  /** display all processed orders */
  public function getProcessedOrders(ProcessedOrderDataTable $dataTable)
  {
    return $dataTable->render('admin.order.processed-order');
  }

  /** display all dropped off orders */
  public function getDroppedOffOrders(DroppedOffOrderDataTable $dataTable)
  {
    return $dataTable->render('admin.order.dropped-off-order');
  }

  /** display all shipped orders */
  public function getShippedOrders(ShippedOrderDataTable $dataTable)
  {
    return $dataTable->render('admin.order.shipped-order');
  }

  /** display all out for delivery orders */
  public function getOutForDeliveryOrders(OutForDeliveryOrderDataTable $dataTable)
  {
    return $dataTable->render('admin.order.out-for-delivery-order');
  }

  /** display all delivered orders */
  public function getDeliveredOrders(DeliveredOrderDataTable $dataTable)
  {
    return $dataTable->render('admin.order.delivered-order');
  }

  /** display all canceled orders */
  public function getCanceledOrders(CanceledOrderDataTable $dataTable)
  {
    return $dataTable->render('admin.order.canceled-order');
  }

  /** Print Order */
  public function printOrder($id) {

    $order = Order::findOrFail($id);
    $shippers = User::where('role', 'shipper')->get();
    $data = [
      'order' => $order,
      'shippers' => $shippers
    ];
    $pdf = Pdf::loadView('admin.order.show', $data);
    return $pdf->download('order.pdf');
  }
  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $order = Order::findOrFail($id);
    $shippers = User::where('role', 'shipper')->get();
    return view('admin.order.show', compact('order', 'shippers'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $order = Order::findOrFail($id);

    // delete order products
    $order->orderProducts()->delete();

    // delete transaction
    $order->transaction()->delete();

    $order->delete();

    return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
  }

  /** Change order status */
  public function changeOrderStatus(Request $request)
  {
    $request->validate([
      'shipper' => ['required_if:order_status,shipping']
    ]);

    $order = Order::findOrFail($request->id);

    $order->order_status = $request->order_status;
    $order->shipper_id = $request->shipper;

    if($request->order_status == 'shipping' && $order->is_broadcasted == 0) {
      $order->save();

      $orderUserName = $order->user->name;
      $shipperPhoneNumber = $order->shipper->phone;
      $orderInvoice = $order->invoice_id;
      $messageText ="Hello $orderUserName, your order with invoice number #$orderInvoice is now en route. Kindly keep an eye on your phone to receive the goods at your earliest convenience. You can contact me via phone number: $shipperPhoneNumber" ;

      $message = new Chat();

      $message->sender_id = $request->shipper;
      $message->receiver_id = $order->user_id;
      $message->message = $messageText;

      $message->save();


      $senderImage = asset($order->shipper->image);
      broadcast(new MessageEvent($message->message, $message->receiver_id, $order->updated_at, $message->sender_id, $senderImage));

      $order->is_broadcasted = 1;
      $order->save();
    }
    else {
      $order->save();
    }

    if($order->order_status == 'delivered') {
      $order->shipper_status = 1;
      $order->customer_status = 1;

      $order->save();
    }

    if($order->order_status == 'canceled') {

      $orderProducts = OrderProduct::where('order_id', $order->id)->get();
      foreach($orderProducts as $item) {
        $product = Product::where('id', $item->product_id)->first();
        $updatedQty = $product->quantity + $item->qty;
        $product->quantity = $updatedQty;
        $product->save();
      }
    }

    toastr('Order Status Updated Successfully!');
    return redirect()->back();
  }

  /** Change payment status */
  public function changePaymentStatus(Request $request)
  {
    $order = Order::findOrFail($request->id);

    $order->payment_status = $request->status;

    $order->save();

    return response(['status' => 'success', 'message' => 'Updated Payment Status!']);
  }
}
