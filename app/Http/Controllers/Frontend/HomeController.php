<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Brand;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\HomePageSetting;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
  {

    $sliders = Slider::where('status', 1)->orderBy('serial', 'asc')->get();
    $flashSaleDate  = FlashSale::first();
    $flashSaleItems = FlashSaleItem::where('show_at_home', 1)->where('status', 1)->get();
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
      'homepageBannerSectionFour'
    ));
  }

  public function getProductsBasedType()
  {
    $productsBasedType = [];

    $productsBasedType['new_arrival'] = Product::where(['product_type' => 'new_arrival', 'is_approved' => 1, 'status' => 1])->orderBy('id', 'DESC')->take(8)->get();

    $productsBasedType['featured_product'] = Product::where(['product_type' => 'featured_product', 'is_approved' => 1, 'status' => 1])->orderBy('id', 'DESC')->take(8)->get();

    $productsBasedType['top_product'] = Product::where(['product_type' => 'top_product', 'is_approved' => 1, 'status' => 1])->orderBy('id', 'DESC')->take(8)->get();

    $productsBasedType['best_product'] = Product::where(['product_type' => 'best_product', 'is_approved' => 1, 'status' => 1])->orderBy('id', 'DESC')->take(8)->get();

    return $productsBasedType;
  }
}
