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
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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
    return view('admin.order.show', compact('order'));
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
    //
  }

  /** Change order status */
  public function changeOrderStatus(Request $request)
  {
    $order = Order::findOrFail($request->id);

    $order->order_status = $request->status;

    $order->save();

    return response(['status' => 'success', 'message' => 'Updated Order Status']);
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
