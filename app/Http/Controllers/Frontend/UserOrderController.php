<?php

namespace App\Http\Controllers\Frontend;

use App\DataTables\UserOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
  public function index(UserOrderDataTable $dataTable)
  {
    return $dataTable->render('frontend.dashboard.order.index');
  }

  public function show(string $id)
  {
    $order = Order::findOrFail($id);

    if($order->user_id != Auth::user()->id) {
      abort(404);
    }

    return view('frontend.dashboard.order.show', compact('order'));
  }
}
