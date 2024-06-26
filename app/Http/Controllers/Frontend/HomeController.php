<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\HomePageSetting;
use App\Models\Product;
use App\Models\Slider;
use App\Models\SubCategory;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
  public function index()
  {
    $sliders = Cache::remember('sliders', 10800, function () {
      return Slider::where('status', 1)->orderBy('serial', 'asc')->get();
    });
    $flashSaleDate  = FlashSale::first();
    $flashSaleItems = FlashSaleItem::where('show_at_home', 1)->where('status', 1)->pluck('product_id')->toArray();
    $popularCategory = HomePageSetting::where('key', 'popular_category_section')->first();
    $brands = Brand::where('status', 1)->where('is_featured', 1)->get();
    $productsBasedType = $this->getProductsBasedType();
    $categoryProductSliderOne  = HomePageSetting::where('key', 'product_slider_section_one')->first();
    $categoryProductSliderTwo  = HomePageSetting::where('key', 'product_slider_section_two')->first();
    $categoryProductSliderThree  = HomePageSetting::where('key', 'product_slider_section_three')->first();

    // banners
    $homepageBannerOne = Advertisement::where('key', 'homepage_banner_section_one')->first();
    $homepageBannerOne = json_decode($homepageBannerOne?->value);

    $homepageBannerSectionTwo = Advertisement::where('key', 'homepage_banner_section_two')->first();
    $homepageBannerSectionTwo = json_decode($homepageBannerSectionTwo?->value);

    $homepageBannerSectionThree = Advertisement::where('key', 'homepage_banner_section_three')->first();
    $homepageBannerSectionThree = json_decode($homepageBannerSectionThree?->value);

    $homepageBannerSectionFour = Advertisement::where('key', 'homepage_banner_section_four')->first();
    $homepageBannerSectionFour = json_decode($homepageBannerSectionFour?->value);

    $blogs = Blog::with('blogCategory')->where('status', 1)->orderBy('id', 'DESC')->take(5)->get();

    return view('frontend.home.home', compact(
      'sliders',
      'flashSaleDate',
      'flashSaleItems',
      'popularCategory',
      'brands',
      'productsBasedType',
      'categoryProductSliderOne',
      'categoryProductSliderTwo',
      'categoryProductSliderThree',
      'homepageBannerOne',
      'homepageBannerSectionTwo',
      'homepageBannerSectionThree',
      'homepageBannerSectionFour',
      'blogs'
    ));
  }

  public function getProductsBasedType()
  {
    $productsBasedType = [];

    $productsBasedType['new_arrival'] = Product::withAvg('productReviews as review_rating', 'rating')
              ->withCount('productReviews as review_count')
              ->with(['variants', 'category', 'productImageGalleries', 'variants.productVariantItems'])
              ->where(['product_type' => 'new_arrival', 'is_approved' => 1, 'status' => 1])
              ->orderBy('id', 'DESC')->take(8)->get();

    $productsBasedType['featured_product'] = Product::withAvg('productReviews as review_rating', 'rating')
              ->withCount('productReviews as review_count')
              ->with(['variants', 'category', 'productImageGalleries', 'variants.productVariantItems'])
              ->where(['product_type' => 'featured_product', 'is_approved' => 1, 'status' => 1])
              ->orderBy('id', 'DESC')->take(8)->get();

    $productsBasedType['top_product'] = Product::withAvg('productReviews as review_rating', 'rating')
              ->withCount('productReviews as review_count')
              ->with(['variants', 'category', 'productImageGalleries', 'variants.productVariantItems'])
              ->where(['product_type' => 'top_product', 'is_approved' => 1, 'status' => 1])
              ->orderBy('id', 'DESC')->take(8)->get();

    $productsBasedType['best_product'] = Product::withAvg('productReviews as review_rating', 'rating')
              ->withCount('productReviews as review_count')
              ->with(['variants', 'category', 'productImageGalleries', 'variants.productVariantItems'])
              ->where(['product_type' => 'best_product', 'is_approved' => 1, 'status' => 1])
              ->orderBy('id', 'DESC')->take(8)->get();

    return $productsBasedType;
  }

  public function showVendorPage()
  {
    $vendors = Vendor::withAvg('productReviews as review_rating', 'rating')->where('status', 1)->paginate(10);
    return view('frontend.pages.vendor', compact('vendors'));
  }

  public function showVendorProductsPage(Request $request, string $id)
  {
    if ($request->has('category')) {
      $category = Category::where('slug', $request->category)->firstOrFail();
      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['category_id' => $category->id, 'status' => 1, 'is_approved' => 1, 'vendor_id' => $id])
        ->when($request->has('range'), function ($query) use ($request) {
          $price = explode(';', $request->range);
          $from = $price[0];
          $to = $price[1];

          return $query->where('price', '>=', $from)->where('price', '<=', $to);
        })
        ->paginate(12);
    } else if ($request->has('subcategory')) {
      $category = SubCategory::where('slug', $request->subcategory)->firstOrFail();
      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['sub_category_id' => $category->id, 'status' => 1, 'is_approved' => 1, 'vendor_id' => $id])
        ->when($request->has('range'), function ($query) use ($request) {
          $price = explode(';', $request->range);
          $from = $price[0];
          $to = $price[1];

          return $query->where('price', '>=', $from)->where('price', '<=', $to);
        })
        ->paginate(12);
    } else if ($request->has('childcategory')) {
      $category = ChildCategory::where('slug', $request->childcategory)->firstOrFail();
      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['child_category_id' => $category->id, 'status' => 1, 'is_approved' => 1, 'vendor_id' => $id])
        ->when($request->has('range'), function ($query) use ($request) {
          $price = explode(';', $request->range);
          $from = $price[0];
          $to = $price[1];

          return $query->where('price', '>=', $from)->where('price', '<=', $to);
        })
        ->paginate(12);
    } else if ($request->has('brand')) {
      $brand = Brand::where('slug', $request->brand)->firstOrFail();

      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['brand_id' => $brand->id, 'status' => 1, 'is_approved' => 1, 'vendor_id' => $id])
        ->when($request->has('range'), function ($query) use ($request) {
          $price = explode(';', $request->range);
          $from = $price[0];
          $to = $price[1];

          return $query->where('price', '>=', $from)->where('price', '<=', $to);
        })
        ->paginate(12);
    } else if ($request->has('search')) {
      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['status' => 1, 'is_approved' => 1, 'vendor_id' => $id])->where(function ($query) use ($request) {
        $query->where('name', 'like', '%' . $request->search . '%')
          ->orWhere('long_description', 'like', '%' . $request->search . '%')
          ->orWhereHas('category', function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
          });
      })
        ->when($request->has('range'), function ($query) use ($request) {
          $price = explode(';', $request->range);
          $from = $price[0];
          $to = $price[1];

          return $query->where('price', '>=', $from)->where('price', '<=', $to);
        })
        ->paginate(12);
    } else if ($request->has('range')) {

      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['status' => 1, 'is_approved' => 1, 'vendor_id' => $id])
        ->when($request->has('range'), function ($query) use ($request) {
          $price = explode(';', $request->range);
          $from = $price[0];
          $to = $price[1];

          return $query->where('price', '>=', $from)->where('price', '<=', $to);
        })
        ->paginate(12);
    } else {
      $products = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['productImageGalleries', 'variants', 'category', 'variants.productVariantItems'])->where(['status' => 1, 'is_approved' => 1, 'vendor_id' => $id])->orderBy('id', 'DESC')->paginate(12);
    }

    $categories = Category::where(['status' => 1])->get();
    $brands = Brand::where(['status' => 1])->get();
    $vendor = Vendor::withAvg('productReviews as review_rating', 'rating')->findOrFail($id);



    return view('frontend.pages.vendor-product-detail', compact('products', 'categories', 'brands', 'vendor'));
  }

  public function showProductModal(string $id)
  {
    $product = Product::withAvg('productReviews as review_rating', 'rating')->withCount('productReviews as review_count')->with(['variants', 'variants.productVariantItems', 'brand'])->findOrFail($id);

    $flashSaleDate  = FlashSale::first();

    $content = view('frontend.layouts.modal', compact('product', 'flashSaleDate'))->render();

    return Response::make($content, 200, ['Content-Type' => 'text/html']);

  }
}
