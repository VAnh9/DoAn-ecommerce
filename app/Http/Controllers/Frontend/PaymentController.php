<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PaypalSetting;
use App\Models\Product;
use App\Models\StripeSetting;
use App\Models\Transaction;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{
  public function index()
  {
    if (!Session::has('shipping')) {
      return redirect()->route('user.checkout');
    }
    return view('frontend.pages.payment');
  }

  public function paymentSuccess()
  {
    return view('frontend.pages.payment-success');
  }

  public function storeOrderAndTransaction($paymentMethod, $paymentStatus, $transactionId, $paidAmount, $paidCurrencyName)
  {
    $setting = GeneralSetting::first();
    $order = new Order();

    $order->invoice_id = rand(1, 999999);
    $order->user_id = Auth::user()->id;
    $order->sub_total = getCartToTalPrice();
    $order->amount = getFinalPayableAmount();
    $order->currency_name = $setting->currency_name;
    $order->currency_icon = $setting->currency_icon;
    $order->product_qty = Cart::content()->count();
    $order->payment_method = $paymentMethod;
    $order->payment_status = $paymentStatus;
    $order->order_address = json_encode(Session::get('shipping')['shipping_address']);
    $order->shipping_method = json_encode(Session::get('shipping')['shipping_method']);
    $order->coupon = json_encode(Session::get('coupon'));
    $order->order_status = 'pending';

    $order->save();

    // store order products
    foreach (Cart::content() as $item) {

      $orderProduct = new OrderProduct();
      $product = Product::findOrFail($item->id);

      $orderProduct->order_id = $order->id;
      $orderProduct->product_id = $item->id;
      $orderProduct->vendor_id = $product->vendor_id;
      $orderProduct->product_name = $product->name;
      $orderProduct->variants = json_encode($item->options->variants);
      $orderProduct->variant_total = $item->options->variants_total_price;
      $orderProduct->unit_price = $item->price;
      $orderProduct->qty = $item->qty;

      $orderProduct->save();
    }

    // store transaction details
    $transaction = new Transaction();

    $transaction->order_id = $order->id;
    $transaction->transaction_id = $transactionId;
    $transaction->payment_method = $paymentMethod;
    $transaction->amount = getFinalPayableAmount();
    $transaction->amount_real_currency = $paidAmount;
    $transaction->amount_real_currency_name = $paidCurrencyName;

    $transaction->save();
  }

  // clear session after complete order
  public function clearSession()
  {
    Cart::destroy();
    Session::forget('shipping');
    Session::forget('coupon');
  }

  public function paypalConfig()
  {
    $paypalSettings = PaypalSetting::first();

    $config = [
      'mode'    => $paypalSettings->mode == 1 ? 'live' : 'sandbox',
      'sandbox' => [
        'client_id'         => $paypalSettings->client_id,
        'client_secret'     => $paypalSettings->secret_key,
        'app_id'            => '',
      ],
      'live' => [
        'client_id'         => $paypalSettings->client_id,
        'client_secret'     => $paypalSettings->secret_key,
        'app_id'            => '',
      ],

      'payment_action' => 'Sale',
      'currency'       => $paypalSettings->currency_name,
      'notify_url'     => '',
      'locale'         => 'en_US',
      'validate_ssl'   => true,
    ];

    return $config;
  }

  /** Paypal redirect */
  public function payWithPaypal()
  {
    $config = $this->paypalConfig();
    $paypalSettings = PaypalSetting::first();

    $provider = new PayPalClient($config);

    $provider->getAccessToken();

    // calculate payable amount depending on currency rate
    $total = getFinalPayableAmount();
    $payableAmount = round($total * $paypalSettings->currency_rate, 2);

    $response = $provider->createOrder([
      "intent" => "CAPTURE",
      "application_context" => [
        'return_url' => route('user.paypal.success'),
        'cancel_url' => route('user.paypal.cancel'),
      ],
      "purchase_units" => [
        [
          "amount" => [
            "currency_code" => $config['currency'],
            "value" => $payableAmount
          ]
        ]
      ]
    ]);

    if (isset($response['id']) && $response['id'] != null) {

      foreach ($response['links'] as $link) {
        if ($link['rel'] == 'approve') {
          return redirect()->away($link['href']);
        }
      }
    } else {
      return redirect()->route('user.paypal.cancel');
    }
  }

  public function paypalSuccess(Request $request)
  {
    $config = $this->paypalConfig();

    $provider = new PayPalClient($config);

    $provider->getAccessToken();

    $response = $provider->capturePaymentOrder($request->token);

    if (isset($response['status']) && $response['status'] == 'COMPLETED') {

      // calculate payable amount depending on currency rate
      $paypalSettings = PaypalSetting::first();
      $total = getFinalPayableAmount();
      $paidAmount = round($total * $paypalSettings->currency_rate, 2);

      $this->storeOrderAndTransaction('Paypal', 1, $response['id'], $paidAmount, $paypalSettings->currency_name);

      // clear session
      $this->clearSession();

      return redirect()->route('user.payment.success');
    }

    return redirect()->route('user.paypal.cancel');
  }

  public function paypalCancel()
  {

    toastr('Something went wrong. Try again later!', 'error');
    return redirect()->route('user.payment');
  }


  /** Stripe payment */
  public function payWithStripe(Request $request)
  {
    $stripeSetting = StripeSetting::first();
    Stripe::setApiKey($stripeSetting->secret_key);


    // calculate payable amount depending on currency rate
    $total = getFinalPayableAmount();
    $payableAmount = round($total * $stripeSetting->currency_rate, 2);

    $response = Charge::create([
      "amount" => $payableAmount * 100, // change to cent (stripe pay by cent)
      "currency" => $stripeSetting->currency_name,
      "source" => $request->stripe_token,
      "description" => "Product Purchase!"
    ]);

    if ($response->status = 'succeeded') {
      $this->storeOrderAndTransaction('Stripe', 1, $response->id, $payableAmount, $stripeSetting->currency_name);

      //clear session
      $this->clearSession();

      return redirect()->route('user.payment.success');
    } else {
      toastr('Something went wrong. Try again later!', 'error');
      return redirect()->route('user.payment');
    }
  }
}
