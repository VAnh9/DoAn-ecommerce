<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductReviewDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
  public function index(ProductReviewDataTable $dataTable)
  {
    return $dataTable->render('admin.product.review.index');
  }

  public function changeStatus(Request $request)
  {
    $productReview = ProductReview::findOrFail($request->id);

    $productReview->status = $request->status == 'true' ? 1 : 0;

    $productReview->save();

    return response(['message' => 'Status has been updated!']);
  }

  public function getImageGallery($id) {

    $productReview = ProductReview::findOrFail($id);


    $productReviewImages = $productReview->productReviewGalleries;

    return view('admin.product.review.image-gallery', compact('productReviewImages'));
  }
}
