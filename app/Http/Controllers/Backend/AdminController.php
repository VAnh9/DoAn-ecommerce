<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
  public function dashboard()
  {
    $todayOrders = Order::whereDate('created_at', Carbon::today())->count();
    $todayPendingOrders = Order::whereDate('created_at', Carbon::today())->where('order_status', 'pending')->count();
    $totalOrders = Order::count();
    $totalPendingOrders = Order::where('order_status', 'pending')->count();
    $totalCancelOrders = Order::where('order_status', 'canceled')->count();
    $totalDeliveredOrders = Order::where('order_status', 'delivered')->count();

    $todayEarnings = Order::where('order_status', '!=', 'canceled')->where('payment_status', 1)->whereDate('created_at', Carbon::today())->sum('sub_total');

    $monthEarnings = Order::where('order_status', '!=', 'canceled')->where('payment_status', 1)->whereMonth('created_at', Carbon::now()->month)->sum('sub_total');

    $yearEarnings = Order::where('order_status', '!=', 'canceled')->where('payment_status', 1)->whereYear('created_at', Carbon::now()->year)->sum('sub_total');

    $totalEarnings = Order::where('order_status', '!=', 'canceled')->where('payment_status', 1)->sum('sub_total');

    $totalReview = ProductReview::count();
    $totalBrand = Brand::count();
    $totalProduct = Product::count();
    $totalBlog = Blog::count();
    $totalSubscriber = NewsletterSubscriber::count();
    $totalVendor = User::where('role', 'vendor')->count();
    $totalUser = User::where('role', 'user')->count();

    return view('admin.dashboard', compact(
      'todayOrders',
      'todayPendingOrders',
      'totalOrders',
      'totalPendingOrders',
      'totalCancelOrders',
      'totalDeliveredOrders',
      'todayEarnings',
      'monthEarnings',
      'yearEarnings',
      'totalEarnings',
      'totalReview',
      'totalBrand',
      'totalProduct',
      'totalBlog',
      'totalSubscriber',
      'totalVendor',
      'totalUser'
    ));
  }

  public function login()
  {
    return view('admin.auth.login');
  }
}
