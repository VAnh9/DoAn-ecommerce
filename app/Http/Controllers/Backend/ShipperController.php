<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipperController extends Controller
{
  public function dashboard()
  {
    $shippingOrder = Order::where('shipper_id', Auth::user()->id)->where('order_status', 'shipping')->count();
    $shippedOrder = Order::where('shipper_id', Auth::user()->id)->where('order_status', 'delivered')->count();
    return view('shipper.dashboard.dashboard', compact('shippingOrder', 'shippedOrder'));
  }
}
