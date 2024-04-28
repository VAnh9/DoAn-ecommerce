<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ShipperOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
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

    $order->order_status = $request->orderStatus;

    $order->save();

    return response(['status' => 'success', 'message' => 'Status has been updated!']);
  }

}
