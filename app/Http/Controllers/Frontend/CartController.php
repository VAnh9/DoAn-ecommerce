<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
  /** Add item to cart */
  public function addToCart(Request $request)
  {

    $product = Product::findOrFail($request->product_id);

    // check the quantity of product is valid or not
    if ($product->quantity == 0) {
      return response(['status' => 'error', 'message' => 'Product stock out!']);
    } else if ($product->quantity < $request->qty) {
      return response(['status' => 'error', 'message' => 'Quantity not available in our stock!']);
    }

    $variants = [];

    $variantToTalPrice = 0;

    if ($request->has('variant_items')) {

      foreach ($request->variant_items as $item_id) {

        $variantItem = ProductVariantItem::find($item_id);

        $variants[$variantItem->productVariant->name]['name'] = $variantItem->name;
        $variants[$variantItem->productVariant->name]['price'] = $variantItem->price;

        $variantToTalPrice += $variantItem->price;
      }
    }

    //check discount product
    $productPriceInMoment = 0;

    if (checkDiscount($product)) {
      $productPriceInMoment = $product->offer_price;
    } else $productPriceInMoment = $product->price;


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
  public function showCartDetails()
  {

    $cartItem = Cart::content();

    // cart banner ad
    $cartPageBanner = Advertisement::where('key', 'cart_page_banner')->first();
    $cartPageBanner = json_decode($cartPageBanner?->value);

    return view('frontend.pages.cart-detail', compact('cartItem', 'cartPageBanner'));
  }

  /** Update product quantity */
  public function updateProductQuantity(Request $request)
  {

    $productId = Cart::get($request->rowId)->id;

    $product = Product::findOrFail($productId);

    // check the quantity of product is valid or not
    if ($product->quantity == 0) {
      return response(['status' => 'error', 'message' => 'Product stock out!']);
    } else if ($product->quantity < $request->quantity) {
      return response(['status' => 'error', 'message' => 'Quantity not available in our stock!']);
    }

    // update quantity
    Cart::update($request->rowId, $request->quantity);

    $totalPrice = $this->calculateTotalPrice($request->rowId);

    return response(['status' => 'success', 'message' => 'Product quantity updated!', 'totalPrice' => $totalPrice]);
  }

  /** Calculate total product price one product */
  public function calculateTotalPrice($rowId)
  {

    $product = Cart::get($rowId);

    $totalPrice = ($product->price + $product->options->variants_total_price) * $product->qty;

    return $totalPrice;
  }

  /** Clear cart */
  public function clearCart()
  {

    Cart::destroy();
    Session::forget('coupon');
    return response(['status' => 'success', 'message' => 'Your cart has been cleared!']);
  }

  /** Remove a single product from cart */
  public function removeProduct($rowId)
  {

    Cart::remove($rowId);

    $count = Cart::count();

    return response(['status' => 'success', 'message' => 'Product removed successfuly!', 'countProduct' => $count]);
  }

  /** get cart count */
  public function getCartCount()
  {

    return Cart::content()->count();
  }

  /** get all cart products */
  public function getCartProducts()
  {
    return Cart::content();
  }

  /** get cart total price of all product in cart */
  public function getCartTotalPrice()
  {

    $total = 0;

    foreach (Cart::content() as $cartProduct) {
      $total += $this->calculateTotalPrice($cartProduct->rowId);
    }

    return $total;
  }

  /** Apply coupon */
  public function applyCoupon(Request $request)
  {
    if ($request->coupon_code == null) {
      return response(['status' => 'error', 'message' => 'Coupon is invalid!']);
    }

    $coupon = Coupon::where(['code' => $request->coupon_code, 'status' => 1])->first();
    $currentDate = date('Y-m-d');

    if ($coupon == null || $coupon->start_date > $currentDate || $coupon->end_date < $currentDate) {
      return response(['status' => 'error', 'message' => 'Coupon is invalid!']);
    } else if ($coupon->total_used >= $coupon->quantity) {
      return response(['status' => 'error', 'message' => 'This coupon is run out!']);
    }
    else if($coupon->max_use <= CouponUser::where('coupon_id', $coupon->id)->where('user_id', Auth::user()->id)->sum('usage_count')) {
      return response(['status' => 'error', 'message' => 'You have expired using this discount code!']);
    }

    if ($coupon->discount_type == 'amount') {
      Session::put('coupon', [
        'id' => $coupon->id,
        'coupon_name' => $coupon->name,
        'coupon_code' => $coupon->code,
        'discount_type' => 'amount',
        'discount' => $coupon->discount_value,
      ]);
    } else if ($coupon->discount_type == 'percent') {
      Session::put('coupon', [
        'id' => $coupon->id,
        'coupon_name' => $coupon->name,
        'coupon_code' => $coupon->code,
        'discount_type' => 'percent',
        'discount' => $coupon->discount_value,
      ]);
    }

    return response(['status' => 'success', 'message' => 'Coupon applied successfully!']);
  }

  /** calculate total price after apply coupon */
  public function calculateCouponDiscount()
  {
    if (Session::has('coupon')) {

      $coupon = Session::get('coupon');
      $originalPrice = getCartToTalPrice();

      if ($coupon['discount_type'] == 'amount') {

        $total = $originalPrice - $coupon['discount'];

        if($total < 0) {
          $total = 0;
        }

        return response(['status' => 'success', 'discount' => $coupon['discount'], 'priceAfterDiscount' => $total]);
      } else if ($coupon['discount_type'] == 'percent') {

        $discount = $originalPrice - ($originalPrice * $coupon['discount'] / 100);

        $total = $originalPrice - $discount;

        return response(['status' => 'success', 'discount' => $discount, 'priceAfterDiscount' => $total]);
      }
    }
    else {
      $total = getCartToTalPrice();
      return response(['status' => 'success', 'priceAfterDiscount' => $total, 'discount' => 0]);

    }
  }
}
