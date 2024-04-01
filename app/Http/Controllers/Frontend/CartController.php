<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /** Add item to cart */
    public function addToCart(Request $request) {

      $product = Product::findOrFail($request->product_id);

      $variants = [];

      $variantToTalPrice = 0;

      if($request->has('variant_items')) {

        foreach($request->variant_items as $item_id) {

          $variantItem = ProductVariantItem::find($item_id);

          $variants[$variantItem->productVariant->name]['name'] = $variantItem->name;
          $variants[$variantItem->productVariant->name]['price'] = $variantItem->price;

          $variantToTalPrice += $variantItem->price;
        }
      }

      //check discount product
      $productPriceInMoment = 0;

      if(checkDiscount($product)) {
        $productPriceInMoment = $product->offer_price;
      }
      else $productPriceInMoment = $product->price;


      $cartData = [];
      $cartData['id'] = $product->id;
      $cartData['name'] = $product->name;
      $cartData['qty'] = $request->qty;
      $cartData['price'] = $productPriceInMoment;
      $cartData['weight'] = 10;
      $cartData['options']['variants'] = $variants;
      $cartData['options']['variants_total_price'] = $variantToTalPrice;
      $cartData['options']['image'] = $product->thumb_image;
      $cartData['options']['slug'] = $product->slug;


      Cart::add($cartData);

      return response(['status' => 'success', 'message' => 'Added to cart successfully!']);
    }

    /** Show cart page */
    public function showCartDetails() {

      $cartItem = Cart::content();
      return view('frontend.pages.cart-detail', compact('cartItem'));
    }

    /** Update product quantity */
    public function updateProductQuantity(Request $request) {

      Cart::update($request->rowId, $request->quantity);

      $totalPrice = $this->calculateTotalPrice($request->rowId);

      return response(['status' => 'success', 'message' => 'Product quantity updated!', 'totalPrice' => $totalPrice]);
    }

    /** Calculate total product price */
    public function calculateTotalPrice($rowId) {

      $product = Cart::get($rowId);

      $totalPrice = ($product->price + $product->options->variants_total_price) * $product->qty;

      return $totalPrice;
    }

    /** Clear cart */
    public function clearCart() {

      Cart::destroy();

      return response(['status' => 'success', 'message' => 'Your cart has been cleared!']);
    }

    /** Remove a single product from cart */
    public function removeProduct($rowId) {

      Cart::remove($rowId);

      $count = Cart::count();

      return response(['status' => 'success', 'message' => 'Deleted successfuly!', 'countProduct' => $count]);
    }

    /** get cart count */
    public function getCartCount() {
      
      return Cart::content()->count();
    }
}
