<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CouponDataTable $dataTable)
    {
        return $dataTable->render('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
          'name' => ['required', 'max:200'],
          'code' => ['required', 'max:200'],
          'quantity' => ['required', 'integer'],
          'max_use' => ['required', 'integer'],
          'start_date' => ['required', 'date', 'after_or_equal:today'],
          'end_date' => ['required', 'date', 'after_or_equal:start_date'],
          'discount_type' => ['required'],
          'discount_value' => ['required', 'numeric'],
          'status' => ['required'],
        ]);

        $coupon = new Coupon();

        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->quantity = $request->quantity;
        $coupon->max_use = $request->max_use;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount_value = $request->discount_value;
        $coupon->status = $request->status;
        $coupon->total_used = 0;

        $coupon->save();

        toastr('Created Successfully!');

        return redirect()->route('admin.coupons.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
          'name' => ['required', 'max:200'],
          'code' => ['required', 'max:200'],
          'quantity' => ['required', 'integer'],
          'max_use' => ['required', 'integer'],
          'start_date' => ['required', 'date', 'after_or_equal:today'],
          'end_date' => ['required', 'date', 'after_or_equal:start_date'],
          'discount_type' => ['required'],
          'discount_value' => ['required', 'numeric'],
          'status' => ['required'],
        ]);

        $coupon = Coupon::findOrFail($id);

        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->quantity = $request->quantity;
        $coupon->max_use = $request->max_use;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount_value = $request->discount_value;
        $coupon->status = $request->status;

        $coupon->save();

        toastr('Updated Successfully!');

        return redirect()->route('admin.coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::findOrFail($id);

        $coupon->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request) {

      $coupon = Coupon::findOrFail($request->id);

      $coupon->status = $request->status == 'true' ? 1 : 0;

      $coupon->save();

      return response(['message' => 'Status has been updated!']);
    }
}
