<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\WithdrawMethodDataTable;
use App\Http\Controllers\Controller;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;

class WithdrawMethodController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(WithdrawMethodDataTable $withdrawMethodDataTable)
  {
    return $withdrawMethodDataTable->render('admin.withdraw.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.withdraw.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => ['required', 'max:200'],
      'minimum_amount' => ['required', 'numeric', 'lt:maximum_amount'],
      'maximum_amount' => ['required', 'numeric', 'gt:minimum_amount'],
      'withdraw_charge' => ['required', 'numeric'],
      'description' => ['required'],
      'status' => ['required'],
    ]);

    $method = new WithdrawMethod();

    $method->name = $request->name;
    $method->minimum_amount = $request->minimum_amount;
    $method->maximum_amount = $request->maximum_amount;
    $method->withdraw_charge = $request->withdraw_charge;
    $method->description = $request->description;
    $method->status = $request->status;

    $method->save();

    toastr('Created Successfully!');

    return redirect()->route('admin.withdraw.index');
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
    $withdraw = WithdrawMethod::findOrFail($id);
    return view('admin.withdraw.edit', compact('withdraw'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $request->validate([
      'name' => ['required', 'max:200'],
      'minimum_amount' => ['required', 'numeric', 'lt:maximum_amount'],
      'maximum_amount' => ['required', 'numeric', 'gt:minimum_amount'],
      'withdraw_charge' => ['required', 'numeric'],
      'description' => ['required'],
      'status' => ['required'],
    ]);

    $method = WithdrawMethod::findOrFail($id);

    $method->name = $request->name;
    $method->minimum_amount = $request->minimum_amount;
    $method->maximum_amount = $request->maximum_amount;
    $method->withdraw_charge = $request->withdraw_charge;
    $method->description = $request->description;
    $method->status = $request->status;

    $method->save();

    toastr('Updated Successfully!');

    return redirect()->route('admin.withdraw.index');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $method = WithdrawMethod::findOrFail($id);

    $method->delete();

    return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
  }

  public function changeStatus(Request $request)
  {
    $method = WithdrawMethod::findOrFail($request->id);

    $method->status = $request->isChecked == 'true' ? 1 : 0;

    $method->save();

    return response(['message' => 'Updated Successfully!']);
  }
}
