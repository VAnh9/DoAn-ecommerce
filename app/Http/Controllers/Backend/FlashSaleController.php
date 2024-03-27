<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FlashSaleItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index(FlashSaleItemDataTable $dataTable) {

      $flashSale = FlashSale::first();
      $products = Product::where('status', 1)->where('is_approved' , 1)->orderBy('id', 'DESC')->get();

      return $dataTable->render('admin.flash-sale.index', compact('flashSale', 'products'));
    }

    public function update(Request $request) {

      $request->validate([
        'end_date' => ['required', 'date', 'after_or_equal:today']
      ]);

      FlashSale::updateOrCreate(
        ['id' => 1],
        ['end_date' => $request->end_date]
      );

      toastr('Updated Successfully!');

      return redirect()->back();
    }

    public function addProduct(Request $request) {

      $request->validate([
        'products' => ['required'],
        'products.*' => ['required', 'unique:flash_sale_items,product_id'],
        'show_at_home' => ['required'],
        'status' => ['required']
      ], [
        'products.*.unique' => 'The product is already in flash sale!',
      ]);

      $flashSale = FlashSale::first();

      foreach($request->products as $product) {

        $flashSaleItem = new FlashSaleItem();

        $flashSaleItem->product_id = $product;
        $flashSaleItem->flash_sale_id = $flashSale->id;
        $flashSaleItem->show_at_home = $request->show_at_home;
        $flashSaleItem->status = $request->status;

        $flashSaleItem->save();
      }

      toastr('Product Added Successfully!');

      return redirect()->back();
    }

    public function changeShowAtHomeStatus(Request $request) {

      $flashSaleItem = FlashSaleItem::findOrFail($request->id);

      $flashSaleItem->show_at_home = $request->status == 'true' ? 1 : 0;

      $flashSaleItem->save();

      return response(['message' => 'Status has been updated!']);
    }

    public function changeStatus(Request $request) {

      $flashSaleItem = FlashSaleItem::findOrFail($request->id);

      $flashSaleItem->status = $request->status == 'true' ? 1 : 0;

      $flashSaleItem->save();

      return response(['message' => 'Status has been updated!']);

    }

    public function destroy(string $id) {

      $flashSaleItem = FlashSaleItem::findOrFail($id);

      $flashSaleItem->delete();

      return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
