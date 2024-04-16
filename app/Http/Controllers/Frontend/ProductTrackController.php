<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ProductTrackController extends Controller
{
  public function index(Request $request) {

    if($request->has('tracker')) {
      $request->validate([
        'tracker' => ['required']
      ]);

      $order = Order::where('invoice_id', $request->tracker)->first();

      if(!isset($order)) {
        toastr('Invoice Not Exist!', 'error');
      }

      return view('frontend.pages.product-tracking', compact('order'));
    }
    else {
      return view('frontend.pages.product-tracking');
    }
  }

}
