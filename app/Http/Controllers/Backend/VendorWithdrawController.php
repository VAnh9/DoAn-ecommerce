<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorWithdrawDataTable;
use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Models\WithdrawMethod;
use App\Models\WithdrawRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VendorWithdrawController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(VendorWithdrawDataTable $vendorWithdrawDataTable)
  {
    $totalEarnings = OrderProduct::where('vendor_id', Auth::user()->vendor->id)->whereHas('order', function($query) {
      $query->where(['payment_status' => 1, 'order_status' => 'delivered']);
    })->sum(DB::raw('(unit_price + variant_total) * qty'));

    $totalWithdraw = WithdrawRequest::where('vendor_id', Auth::user()->vendor->id)->where('status', 'paid')->sum('total_amount');

    $currentBalance = $totalEarnings - $totalWithdraw;

    $pendingAmount = WithdrawRequest::where('vendor_id', Auth::user()->vendor->id)->where('status', 'pending')->sum('total_amount');

    return $vendorWithdrawDataTable->render('vendor.withdraw.index', compact('currentBalance', 'totalWithdraw', 'pendingAmount'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $withdrawMethods = WithdrawMethod::where('status', 1)->get();
    return view('vendor.withdraw.create', compact('withdrawMethods'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'withdraw_method' => ['required', 'integer'],
      'withdraw_amount' => ['required', 'numeric'],
      'account_info' => ['required', 'max:2000']
    ]);

    $method = WithdrawMethod::findOrFail($request->withdraw_method);

    if ($request->withdraw_amount < $method->minimum_amount || $request->withdraw_amount > $method->maximum_amount) {
      $error = ValidationException::withMessages(["Amount must be greater than $method->minimum_amount and less than $method->maximum_amount!"]);
      toastr($error->getMessage(), 'error');
      return redirect()->back();
    }

    $totalEarnings = OrderProduct::where('vendor_id', Auth::user()->vendor->id)->whereHas('order', function($query) {
      $query->where(['payment_status' => 1, 'order_status' => 'delivered']);
    })->sum(DB::raw('(unit_price + variant_total) * qty'));

    $totalWithdraw = WithdrawRequest::where('vendor_id', Auth::user()->vendor->id)->where('status', 'paid')->sum('total_amount');

    $currentBalance = $totalEarnings - $totalWithdraw;

    if($request->withdraw_amount > $currentBalance) {
      $error = ValidationException::withMessages(["Insufficient Balance!"]);
      toastr($error->getMessage(), 'error');
      return redirect()->back();
    }

    if(WithdrawRequest::where('vendor_id', Auth::user()->vendor->id)->where('status', 'pending')->exists()) {
      $error = ValidationException::withMessages(["You already have a pending request!"]);
      toastr($error->getMessage(), 'error');
      return redirect()->back();
    }

    $withdraw = new WithdrawRequest();

    $withdraw->vendor_id  = Auth::user()->vendor->id;
    $withdraw->method = $method->name;
    $withdraw->total_amount = $request->withdraw_amount;
    $withdraw->withdraw_amount = $request->withdraw_amount - ($method->withdraw_charge / 100) * $request->withdraw_amount;
    $withdraw->withdraw_charge = ($method->withdraw_charge / 100) * $request->withdraw_amount;
    $withdraw->account_info = $request->account_info;

    $withdraw->save();

    toastr('Request added successfully!');

    return redirect()->route('vendor.withdraw.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $methodInfo = WithdrawMethod::findOrFail($id);

    return response($methodInfo);
  }

  public function showDetailRequest(string $id)
  {
    $withdrawRequest = WithdrawRequest::findOrFail($id);

    if($withdrawRequest->vendor_id != Auth::user()->vendor->id) {
      abort(404);
    }

    return view('vendor.withdraw.show', compact('withdrawRequest'));
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
}
