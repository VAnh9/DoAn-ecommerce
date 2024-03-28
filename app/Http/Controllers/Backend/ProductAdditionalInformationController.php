<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductAdditionalInformationDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAdditionalInformation;
use Illuminate\Http\Request;

class ProductAdditionalInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ProductAdditionalInformationDataTable $dataTable)
    {
        $product = Product::findOrFail($request->product);
        return $dataTable->render('admin.product.additional-information.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.additional-information.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
          'name' => ['required', 'max:200'],
          'specifications' => ['required', 'max:200'],
          'status' => ['required']
        ]);

        $productInfor = new ProductAdditionalInformation();

        $productInfor->name = $request->name;
        $productInfor->specifications = $request->specifications;
        $productInfor->product_id = $request->product;
        $productInfor->status = $request->status;

        $productInfor->save();

        toastr('Created Successfully!');

        return redirect()->route('admin.product-additional-information.index', ['product' => $request->product]);

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
        $productInfo = ProductAdditionalInformation::findOrFail($id);
        return view('admin.product.additional-information.edit', compact('productInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
          'name' => ['required', 'max:200'],
          'specifications' => ['required', 'max:200'],
          'status' => ['required']
        ]);

        $productInfor = ProductAdditionalInformation::findOrFail($id);

        $productInfor->name = $request->name;
        $productInfor->specifications = $request->specifications;
        $productInfor->status = $request->status;

        $productInfor->save();

        toastr('Updated Successfully!');

        return redirect()->route('admin.product-additional-information.index', ['product' => $productInfor->product_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productInfo = ProductAdditionalInformation::findOrFail($id);

        $productInfo->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request) {

      $productInfo = ProductAdditionalInformation::findOrFail($request->id);

      $productInfo->status = $request->status == 'true' ? 1 : 0;

      $productInfo->save();

      return response(['message' => 'Status has been updated!']);
    }
}
