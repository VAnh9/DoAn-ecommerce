<?php

namespace App\Http\Controllers\Frontend;

use App\DataTables\UserProductReviewsDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\ProductReviewGallery;
use App\Rules\badWord;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
  use ImageUploadTrait;

  public function index(UserProductReviewsDataTable $dataTable)
  {
    return $dataTable->render('frontend.dashboard.review.index');
  }

  public function getImageGallery($id)
  {
    $productReview = ProductReview::findOrFail($id);

    if($productReview->user_id != Auth::user()->id) {
      abort(404);
    }

    $productReviewImages = $productReview->productReviewGalleries;

    return view('frontend.dashboard.review.image-gallery', compact('productReviewImages'));
  }

  public function postReview(Request $request)
  {
    $request->validate([
      'star_rate' => ['required'],
      'review' => ['required', 'max:500'],
      'image.*' => ['nullable', 'image'],
    ], [
      'star_rate.required' => 'Rating field is required',
      'image.*.image' => 'Image not valid'
    ]);

    $checkReviewExist = ProductReview::where(['product_id' => $request->product_id, 'user_id' => Auth::user()->id])->first();

    if ($checkReviewExist) {
      toastr('You already added review for this product!', 'error');
      return redirect()->back();
    }

    $badWords = ['shoot', 'fuck', 'gun', 'punch'];

    $originalReview = $request->review;

    $reviewAfterCheck = $this->checkVadidReview($badWords, $originalReview);

    $imagePaths = $this->uploadMultiImage($request, 'image', 'uploads');

    $productReview = new ProductReview();

    $productReview->product_id = $request->product_id;
    $productReview->user_id = Auth::user()->id;
    $productReview->vendor_id = $request->vendor_id;
    $productReview->rating = $request->star_rate;
    $productReview->review = $request->review != $reviewAfterCheck ? $reviewAfterCheck : $request->review;
    $productReview->status = 1;

    $productReview->save();

    if (!empty($imagePaths)) {
      foreach ($imagePaths as $path) {

        $reviewGallery = new ProductReviewGallery();

        $reviewGallery->product_review_id = $productReview->id;
        $reviewGallery->image = $path;

        $reviewGallery->save();
      }
    }

    toastr('Review added successfully!');

    return redirect()->back();
  }

  public function checkVadidReview(array $badWords, string &$value) {

    foreach($badWords as $badWord) {

      $pattern = '/\b' . preg_quote($badWord, '/') . '\b/i';

      $replacement = str_repeat('*' , strlen($badWord));

      $value = preg_replace($pattern, $replacement, $value);
    }

    return $value;
  }
}
