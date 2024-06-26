<?php

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Session;

/** Set Sidebar item active */
function setActive(array $route)
{
  if (is_array($route)) {
    foreach ($route as $r) {
      if (request()->routeIs($r)) {
        return 'active';
      }
    }
  }
}

/** Check if product has discount */

function checkDiscount($product)
{

  $currentDate = date('Y-m-d');

  if ($product->offer_price > 0 && $currentDate >= $product->offer_start_date && $currentDate <= $product->offer_end_date) {
    return true;
  }

  return false;
}

/** Calculate discount percent */

function calculateDiscountPercent($originalPrice, $discountPrice)
{

  $discountAmount = $originalPrice - $discountPrice;
  $discountPercent = ($discountAmount / $originalPrice) * 100;

  return round($discountPercent);
}

/** convert product type */

function productType($type)
{

  switch ($type) {
    case 'new_arrival':
      return 'New';
      break;
    case 'featured_product':
      return 'Featured';
      break;
    case 'top_product':
      return 'Top';
      break;
    case 'best_product':
      return 'Best';
      break;
    default:
      return '';
      break;
  }
}

/** get total cart price */

function getCartToTalPrice()
{
  $total = 0;
  /** @disregard P1009 */
  foreach (\Cart::content() as $cartProduct) {
    $total += ($cartProduct->price + $cartProduct->options->variants_total_price) * $cartProduct->qty;
  }

  return $total;
}

/** get total amount after apply discount */
function getPriceAfterApplyDiscount()
{
  if (Session::has('coupon')) {

    $coupon = Session::get('coupon');
    $originalPrice = getCartToTalPrice();

    if ($coupon['discount_type'] == 'amount') {

      $total = $originalPrice - $coupon['discount'];

      if ($total < 0) $total = 0;

      return $total;
    } else if ($coupon['discount_type'] == 'percent') {

      $discount = round($originalPrice - ($originalPrice * $coupon['discount'] / 100), 2);

      $total = $originalPrice - $discount;

      return $total;
    }
  } else return getCartToTalPrice();
}

/** get discount price from coupon */
function getDiscountPrice()
{
  if (Session::has('coupon')) {

    $coupon = Session::get('coupon');
    $originalPrice = getCartToTalPrice();

    if ($coupon['discount_type'] == 'amount') {

      return $coupon['discount'];
    } else if ($coupon['discount_type'] == 'percent') {

      $discount = $originalPrice - ($originalPrice * $coupon['discount'] / 100);

      return round($discount,2);
    }
  } else return 0;
}

/** get shipping fee from session */
function getShippingFee()
{
  if (Session::has('shipping')) {
    return Session::get('shipping')['shipping_method']['cost'];
  } else return 0;
}

/** get final price in payment page (with shipping fee and coupon) */
function getFinalPayableAmount()
{
  return getPriceAfterApplyDiscount() + getShippingFee();
}

/** calculate discount coupon on order page */
function calculateDiscountCoupon($subTotal, $coupon)
{

  if ($coupon->discount_type == 'amount') {

    return $coupon->discount;
  } else if ($coupon->discount_type == 'percent') {

    $discount = $subTotal - ($subTotal * $coupon->discount / 100);

    return $discount;
  }
}


/** limit text */
function limitText($text, $limit = 20)
{
  /** @disregard P1009 */
  return \Str::limit($text, $limit);
}

function getCurrencyIcon()
{
  $settings = GeneralSetting::first();
  return $settings->currency_icon;
}
