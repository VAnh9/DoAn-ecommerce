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
      $flashSaleItems = FlashSaleItem::where('status', 1)->orderBy('id', 'ASC')->paginate(20);

      // flashsale banner ad
      $flashsalePageBanner = Advertisement::where('key', 'flashsale_page_banner')->first();
      $flashsalePageBanner = json_decode($flashsalePageBanner?->value);

      return view('frontend.pages.flash-sale', compact('flashSaleDate', 'flashSaleItems', 'flashsalePageBanner'));
    }
}
