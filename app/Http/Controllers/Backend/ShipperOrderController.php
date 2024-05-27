<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ShipperOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShipperOrderController extends Controller
{
  public function index(ShipperOrderDataTable $shipperOrderDataTable)
  {
    return $shipperOrderDataTable->render('shipper.order.index');
  }
  public function changeOrderStatus(Request $request)
  {
    $order = Order::findOrFail($request->orderId);

    $order->shipper_status = $request->orderStatus == 'delivered' ? 1 : 0;

    if($request->orderStatus == 'delivered') {
      $order->shipping_arrive_at = Carbon::now();
    }

    $order->save();

    return response(['status' => 'success', 'message' => 'Status has been updated!']);
  }

}
