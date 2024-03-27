<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ShippingRuleDataTable;
use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use Illuminate\Http\Request;

class ShippingRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ShippingRuleDataTable $dataTable)
    {
        return $dataTable->render('admin.shipping-rule.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shipping-rule.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
          'name' => ['required', 'max:200'],
          'type' => ['required'],
          'min_cost' => ['nullable', 'numeric'],
          'cost' => ['required', 'numeric'],
          'status' => ['required']
        ]);

        $shippingRule = new ShippingRule();

        $shippingRule->name = $request->name;
        $shippingRule->type = $request->type;
        $shippingRule->min_cost = $request->min_cost;
        $shippingRule->cost = $request->cost;
        $shippingRule->status = $request->status;

        $shippingRule->save();

        toastr('Created Successfully!');

        return redirect()->route('admin.shipping-rule.index');
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
        $shippingRule = ShippingRule::findOrFail($id);
        return view('admin.shipping-rule.edit', compact('shippingRule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
          'name' => ['required', 'max:200'],
          'type' => ['required'],
          'min_cost' => ['nullable', 'numeric'],
          'cost' => ['required', 'numeric'],
          'status' => ['required']
        ]);

        $shippingRule = ShippingRule::findOrFail($id);

        $shippingRule->name = $request->name;
        $shippingRule->type = $request->type;
        if($request->type == 'flat_cost') {
          $shippingRule->min_cost = 0;
        }
        else $shippingRule->min_cost = $request->min_cost;
        $shippingRule->cost = $request->cost;
        $shippingRule->status = $request->status;

        $shippingRule->save();

        toastr('Updated Successfully!');

        return redirect()->route('admin.shipping-rule.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shippingRule = ShippingRule::findOrFail($id);

        $shippingRule->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request) {

      $shippingRule = ShippingRule::findOrFail($request->id);

      $shippingRule->status = $request->status == 'true' ? 1 : 0;

      $shippingRule->save();

      return response(['message' => 'Status has been updated!']);
    }
}
