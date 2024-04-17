<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
  public function dashboard()
  {
    $todayOrders = Order::whereDate('created_at', Carbon::today())->whereHas('orderProducts', function($query) {
      $query->where('vendor_id', Auth::user()->vendor->id);
    })->count();

    $todayPendingOrders = Order::whereDate('created_at', Carbon::today())->where('order_status', 'pending')->whereHas('orderProducts', function($query) {
      $query->where('vendor_id', Auth::user()->vendor->id);
    })->count();

    $totalOrders = Order::whereHas('orderProducts', function($query) {
      $query->where('vendor_id', Auth::user()->vendor->id);
    })->count();

    $totalPendingOrders = Order::where('order_status', 'pending')->whereHas('orderProducts', function($query) {
      $query->where('vendor_id', Auth::user()->vendor->id);
    })->count();

    $totalCompleteOrders = Order::where('order_status', 'delivered')->whereHas('orderProducts', function($query) {
      $query->where('vendor_id', Auth::user()->vendor->id);
    })->count();

    $totalProducts = Product::where('vendor_id', Auth::user()->vendor->id)->count();

    $todayEarning = Order::whereDate('created_at', Carbon::today())
    ->where(['order_status' => 'delivered', 'payment_status' => 1])
    ->whereHas('orderProducts', function($query) {
      $query->where('vendor_id', Auth::user()->vendor->id);
    })->with(['orderProducts' => function ($query) {
      $query->where('vendor_id', Auth::user()->vendor->id);
    }])->get();
    $todayEarning = $todayEarning->sum(function ($order) {
      return $order->orderProducts->sum(function ($product) {
          return ($product->unit_price + $product->variant_total) * $product->qty;
      });
    });;

    $monthEarning = Order::whereMonth('created_at', Carbon::now()->month)
    ->where(['order_status' => 'delivered', 'payment_status' => 1])
    ->whereHas('orderProducts', function($query) {
      $query->where('vendor_id', Auth::user()->vendor->id);
    })->with(['orderProducts' => function ($query) {
      $query->where('vendor_id', Auth::user()->vendor->id);
    }])->get();
    $monthEarning = $monthEarning->sum(function ($order) {
      return $order->orderProducts->sum(function ($product) {
          return ($product->unit_price + $product->variant_total) * $product->qty;
      });
    });

    $yearEarning = Order::whereYear('created_at', Carbon::now()->year)
    ->where(['order_status' => 'delivered', 'payment_status' => 1])
    ->whereHas('orderProducts', function($query) {
      $query->where('vendor_id', Auth::user()->vendor->id);
    })->with(['orderProducts' => function ($query) {
      $query->where('vendor_id', Auth::user()->vendor->id);
    }])->get();
    $yearEarning = $yearEarning->sum(function ($order) {
      return $order->orderProducts->sum(function ($product) {
          return ($product->unit_price + $product->variant_total) * $product->qty;
      });
    });

    $totalEarning = Order::where(['order_status' => 'delivered', 'payment_status' => 1])
    ->whereHas('orderProducts', function($query) {
      $query->where('vendor_id', Auth::user()->vendor->id);
    })->with(['orderProducts' => function ($query) {
      $query->where('vendor_id', Auth::user()->vendor->id);
    }])->get();
    $totalEarning = $totalEarning->sum(function ($order) {
      return $order->orderProducts->sum(function ($product) {
          return ($product->unit_price + $product->variant_total) * $product->qty;
      });
    });


    $review = ProductReview::where('vendor_id', Auth::user()->vendor->id)->count();

    return view('vendor.dashboard.dashboard', compact(
      'todayOrders',
      'todayPendingOrders',
      'totalOrders',
      'totalPendingOrders',
      'totalCompleteOrders',
      'totalProducts',
      'todayEarning',
      'monthEarning',
      'yearEarning',
      'totalEarning',
      'review'
    ));
  }
}
