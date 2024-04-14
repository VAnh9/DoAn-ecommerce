<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductReviewsDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductReviewController extends Controller
{
  public function index(VendorProductReviewsDataTable $dataTable)
  {
    return $dataTable->render('vendor.review.index');
  }

  public function getImageGallery($id)
  {
    $productReview = ProductReview::findOrFail($id);

    if($productReview->vendor_id != Auth::user()->vendor->id) {
      abort(404);
    }

    $productReviewImages = $productReview->productReviewGalleries;

    return view('vendor.review.image-gallery', compact('productReviewImages'));
  }
}
