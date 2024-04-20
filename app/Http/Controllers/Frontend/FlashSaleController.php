<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index() {

      $flashSaleDate  = FlashSale::first();
      $flashSaleItems = FlashSaleItem::where('status', 1)->pluck('product_id')->toArray();

      // flashsale banner ad
      $flashsalePageBanner = Advertisement::where('key', 'flashsale_page_banner')->first();
      $flashsalePageBanner = json_decode($flashsalePageBanner?->value);

      return view('frontend.pages.flash-sale', compact('flashSaleDate', 'flashSaleItems', 'flashsalePageBanner'));
    }
}
