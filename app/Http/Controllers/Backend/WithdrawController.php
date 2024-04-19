<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\WithdrawRequestDataTable;
use App\Http\Controllers\Controller;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
  public function index(WithdrawRequestDataTable $withdrawRequest)
  {
    return $withdrawRequest->render('admin.withdraw.withdraw-request.index');
  }

  public function show(string $id)
  {
    $withdrawRequest = WithdrawRequest::findOrFail($id);

    return view('admin.withdraw.withdraw-request.show', compact('withdrawRequest'));
  }

  public function update(Request $request, string $id)
  {
    $request->validate([
      'status' => ['required', 'in:pending,paid,decline']
    ]);

    $withdrawRequest = WithdrawRequest::findOrFail($id);
    
    $withdrawRequest->status = $request->status;

    $withdrawRequest->save();

    toastr('Updated Successfully!');

    return redirect()->route('admin.withdraw-list.index');
  }
}
