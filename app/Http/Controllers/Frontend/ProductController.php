<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\FlashSale;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\SubCategory;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
  /** Show product at detail page */
  public function showProduct(string $slug)
  {

    $product = Product::withAvg('productReviews as review_rating', 'rating')
      ->withCount('productReviews as review_count')
      ->with(['category', 'productImageGalleries', 'variants', 'brand', 'productAdditionalInformation', 'variants.productVariantItems'])
    ->where('slug', $slug)->where('status', 1)->firstOrFail();
    $vendor = Vendor::withAvg('productReviews as review_rating', 'rating')
      ->withCount('productReviews as review_count')
      ->with('user')
      ->where('id', $product->vendor_id)
      ->firstOrFail();
    $flashSaleDate  = FlashSale::first();
    $reviews = ProductReview::with(['user', 'productReviewGalleries'])->where(['product_id' => $product->id, 'status' => 1])->orderBy('id', 'DESC')->paginate(5);

    $relatedProducts = Product::withAvg('productReviews as review_rating', 'rating')
      ->withCount('productReviews as review_count')
      ->with(['category', 'productImageGalleries', 'variants', 'variants.productVariantItems'])
      ->where('slug', '!=', $slug)
      ->where('category_id', $product->category_id)
      ->where('status', 1)->get();

    return view('frontend.pages.product-detail', compact('product', 'vendor', 'flashSaleDate', 'reviews', 'relatedProducts'));
  }

  /** Show products at product page */
  public function productsIndex(Request $request)
  {
    if ($request->has('category')) {
      $category = Category::where('slug', $request->category)->firstOrFail();
      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['category_id' => $category->id, 'status' => 1, 'is_approved' => 1])
      ->when($request->has('range'), function($query) use ($request) {
        $price = explode(';', $request->range);
        $from = $price[0];
        $to = $price[1];

        return $query->where('price', '>=', $from)->where('price', '<=', $to);
      })
      ->paginate(12);
    }
    else if($request->has('subcategory')) {
      $category = SubCategory::where('slug', $request->subcategory)->firstOrFail();
      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['sub_category_id' => $category->id, 'status' => 1, 'is_approved' => 1])
      ->when($request->has('range'), function($query) use ($request) {
        $price = explode(';', $request->range);
        $from = $price[0];
        $to = $price[1];

        return $query->where('price', '>=', $from)->where('price', '<=', $to);
      })
      ->paginate(12);
    }
    else if($request->has('childcategory')) {
      $category = ChildCategory::where('slug', $request->childcategory)->firstOrFail();
      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['child_category_id' => $category->id, 'status' => 1, 'is_approved' => 1])
      ->when($request->has('range'), function($query) use ($request) {
        $price = explode(';', $request->range);
        $from = $price[0];
        $to = $price[1];

        return $query->where('price', '>=', $from)->where('price', '<=', $to);
      })
      ->paginate(12);
    }
    else if($request->has('brand')) {
      $brand = Brand::where('slug', $request->brand)->firstOrFail();

      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['brand_id' => $brand->id, 'status' => 1, 'is_approved' => 1])
      ->when($request->has('range'), function($query) use ($request) {
        $price = explode(';', $request->range);
        $from = $price[0];
        $to = $price[1];

        return $query->where('price', '>=', $from)->where('price', '<=', $to);
      })
      ->paginate(12);
    }
    else if($request->has('search')) {
      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['status' => 1, 'is_approved' => 1])->where(function($query) use ($request) {
        $query->where('name', 'like', '%'.$request->search.'%')
              ->orWhere('long_description', 'like', '%'.$request->search.'%')
              ->orWhereHas('category', function($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%');
              });
      })
      ->when($request->has('range'), function($query) use ($request) {
        $price = explode(';', $request->range);
        $from = $price[0];
        $to = $price[1];

        return $query->where('price', '>=', $from)->where('price', '<=', $to);
      })
      ->paginate(12);
    }
    else if($request->has('range')) {

      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['status' => 1, 'is_approved' => 1])
      ->when($request->has('range'), function($query) use ($request) {
        $price = explode(';', $request->range);
        $from = $price[0];
        $to = $price[1];

        return $query->where('price', '>=', $from)->where('price', '<=', $to);
      })
      ->paginate(12);
    }
    else {
      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['status' => 1, 'is_approved' => 1])->orderBy('id', 'DESC')->paginate(12);
    }

    $categories = Category::where(['status' => 1])->get();
    $brands = Brand::where(['status' => 1])->get();

    // product banner ad
    $productPageBanner = Advertisement::where('key', 'product_page_banner')->first();
    $productPageBanner = json_decode($productPageBanner?->value);


    return view('frontend.pages.product', compact('products', 'categories', 'brands', 'productPageBanner'));
  }

  public function changeProductFormatView(Request $request)
  {
    Session::put('product_format_view', $request->format);
  }
}
