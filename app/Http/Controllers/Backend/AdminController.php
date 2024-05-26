<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

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

    // get best selling vendor
    /** @disregard P1009 */
    $bestSellingVendorId = Order::where('order_status', 'delivered')
    ->where('payment_status', 1)
    ->join('order_products', 'orders.id', '=', 'order_products.order_id')
    ->select('order_products.vendor_id', DB::raw('SUM((order_products.variant_total + order_products.unit_price) * order_products.qty) as total_earnings'))
    ->groupBy('order_products.vendor_id')
    ->orderBy('total_earnings', 'desc')
    ->first();

    if($bestSellingVendorId) {
      $bestSellingVendor = Vendor::where('id', $bestSellingVendorId->vendor_id)->pluck('name')[0];
    } else {
      $bestSellingVendor = "-";
    }

    // get user buy most product
    /** @disregard P1009 */
    $featuredUserId = Order::select('user_id', DB::raw('count(*) as order_count'))->groupBy('user_id')
    ->orderBy('order_count', 'desc')->first();

    if($featuredUserId) {
      $featuredUser = User::where('id', $featuredUserId->user_id)->pluck('name')[0];
    }
    else $featuredUser = '-';

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
      'bestSellingVendor',
      'totalUser',
      'featuredUser'
    ));
  }

  public function login()
  {
    return view('admin.auth.login');
  }
}
