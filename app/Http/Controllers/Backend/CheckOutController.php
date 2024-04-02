<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use App\Models\UserAddress;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller
{
  public function index()
  {
    if(!Session::has('cart') || Cart::count() == 0 ) {
      return redirect()->route('cart-details');
    }
    $addresses = UserAddress::where('user_id', Auth::user()->id)->get();
    $shippingMethods = ShippingRule::where('status', 1)->get();
    return view('frontend.pages.checkout', compact('addresses', 'shippingMethods'));
  }

  public function createAddress(Request $request)
  {
    $request->validate([
      'name' => ['required', 'max:200'],
      'phone' => ['required', 'max:20'],
      'email' => ['nullable', 'email'],
      'country' => ['required'],
      'city' => ['required'],
      'district' => ['nullable', 'max:200'],
      'zip' => ['nullable', 'max:200'],
      'address' => ['required']
    ]);

    $address = new UserAddress();

    $address->name = $request->name;
    $address->user_id = Auth::user()->id;
    $address->phone = $request->phone;
    $address->email = $request->email;
    $address->country = $request->country;
    $address->city = $request->city;
    $address->district = $request->district;
    $address->zip_code = $request->zip;
    $address->address = $request->address;

    $address->save();

    toastr('Address created successfully!');

    return redirect()->back();
  }

  public function checkOutFormSubmit(Request $request)
  {
    $request->validate([
      'shipping_method_id' => ['required', 'integer'],
      'shipping_address_id' => ['required', 'integer']
    ]);

    $shippingMethod = ShippingRule::findOrFail($request->shipping_method_id);
    $address = UserAddress::findOrFail($request->shipping_address_id)->toArray();

    Session::put('shipping', [
      'shipping_method' => [
        'id' => $shippingMethod->id,
        'name' => $shippingMethod->name,
        'type' => $shippingMethod->type,
        'cost' => $shippingMethod->cost
      ],
      'shipping_address' => $address,
    ]);


    return response(['status' => 'success', 'redirect_url' => route('user.payment')]);
  }
}
