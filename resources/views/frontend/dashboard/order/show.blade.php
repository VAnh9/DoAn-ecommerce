@php
  $address = json_decode($order->order_address);
  $shipping = json_decode($order->shipping_method);
  $coupon = json_decode($order->coupon);
@endphp

@extends('frontend.dashboard.layouts.master')

@section('title')
  {{ $settings->site_name }} || Order
@endsection


@section('content')


  <section id="wsus__dashboard">
    <div class="container-fluid">
        @include('frontend.dashboard.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <div class="d-flex justify-content-between">
              <h4><i class="far fa-store"></i>Order Details</h4>
              <a href="{{ route('user.orders.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="wsus__dashboard_profile">
                <!--============================
                    INVOICE PAGE START
                ==============================-->
                <section id="" class="invoice-print">
                  <div class="">
                      <div class="wsus__invoice_area">
                          <div class="wsus__invoice_header">
                              <div class="wsus__invoice_content">
                                  <div class="row">
                                      <div class="col-xl-4 col-md-4 mb-5 mb-md-0">
                                          <div class="wsus__invoice_single">
                                              <h5>Billing Information</h5>
                                              <h6>{{ $address->name }}</h6>
                                              <p>{{ $address->email }}</p>
                                              <p>{{ $address->phone }}</p>
                                              <p>{{ $address->address }}, {{ $address->city }}, {{ $address->zip_code }} </p>
                                              <p>{{ $address->country }}</p>
                                          </div>
                                      </div>
                                      <div class="col-xl-4 col-md-4 mb-5 mb-md-0">
                                          <div class="wsus__invoice_single text-md-center">
                                              <h5>shipping information</h5>
                                              <h6>{{ $address->name }}</h6>
                                              <p>{{ $address->email }}</p>
                                              <p>{{ $address->phone }}</p>
                                              <p>{{ $address->address }}, {{ $address->city }}, {{ $address->zip_code }} </p>
                                              <p>{{ $address->country }}</p>
                                          </div>
                                      </div>
                                      <div class="col-xl-4 col-md-4">
                                          <div class="wsus__invoice_single text-md-end">
                                              <h5>Order id: #{{ $order->invoice_id }}</h5>
                                              <h6>Order status: {{ config('order_status.order_status_admin')[$order->order_status]['status'] }}</h6>
                                              <p>Payment Method: {{ $order->payment_method }}</p>
                                              <p>Payment Status: {{ $order->payment_status == 1 ? 'Complete' : 'Pending' }}</p>
                                              <p>Transaction id: {{ $order->transaction->transaction_id }}</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="wsus__invoice_description">
                                  <div class="table-responsive">
                                      <table class="table">
                                          <tr>
                                              <th class="name">
                                                  product
                                              </th>
                                              <th class="amount">
                                                  vendor
                                              </th>

                                              <th class="amount">
                                                  amount
                                              </th>

                                              <th class="quentity">
                                                  quantity
                                              </th>
                                              <th class="total">
                                                  total
                                              </th>
                                          </tr>
                                          @foreach ($order->orderProducts as $product )
                                              @php
                                                $variants = json_decode($product->variants);
                                              @endphp
                                              <tr>
                                                  <td class="name">
                                                      <p>{{ $product->product_name }}</p>
                                                      @foreach ($variants as $key => $item )
                                                        <span>{{$key}} : {{$item->name}} ({{$order->currency_icon}}{{$item->price}})</span>
                                                      @endforeach
                                                  </td>

                                                  <td class="amount">
                                                    {{ $product->vendor->name }}
                                                  </td>

                                                  <td class="amount">
                                                    {{$order->currency_icon}}{{ $product->unit_price }}
                                                  </td>

                                                  <td class="quentity">
                                                      {{ $product->qty }}
                                                  </td>
                                                  <td class="total">
                                                    {{$order->currency_icon}}{{ ($product->unit_price + $product->variant_total) * $product->qty }}
                                                  </td>
                                              </tr>
                                          @endforeach
                                      </table>
                                  </div>
                              </div>
                          </div>
                          <div class="wsus__invoice_footer">
                            <div class="ms-auto col-md-2">
                              <p class=""><span>Sub Total:</span> {{$order->currency_icon}}{{ $order->sub_total }} </p>
                              <p class=""><span>Shipping Fee (+):</span> {{$order->currency_icon}}{{ $shipping->cost }}</p>
                              <p class=""><span>Coupon (-):</span> {{$order->currency_icon}}{{ @$coupon->discount ? calculateDiscountCoupon($order->sub_total, $coupon) : 0 }} </p>
                              <p class=""><span>Total Amount:</span> {{$order->currency_icon}}{{ $order->amount }} </p>
                            </div>
                          </div>
                      </div>
                  </div>
                </section>
                <!--============================
                    INVOICE PAGE END
                ==============================-->

                <div class="row">

                  <div class="col-md-12 text-end">
                    <button class="print-btn btn btn-warning mt-5 text-white"><i class="fas fa-print me-1"></i>Print</button>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



@endsection

@push('scripts')

<script>
  // print order
  $('.print-btn').on('click', function() {
      let printContent = $('.invoice-print').html();

      // let originalContent = $('body').html();

      // $('body').html(printContent);

      // window.print();

      // $('body').html(originalContent);

      let http = "http://127.0.0.1:8000";

      var css= `<link rel=\"stylesheet\" href=\"${http}/backend/assets/modules/bootstrap/css/bootstrap.min.css\"><link rel=\"stylesheet\" href=\"${http}/backend/assets/modules/fontawesome/css/all.min.css\"><link rel=\"stylesheet\" href=\"${http}/backend/assets/css/style.css\"><link rel=\"stylesheet\" href=\"${http}/backend/assets/css/components.css\">`;

         var anotherWindow = window.open('', 'Print-Window');
         anotherWindow.document.open();
         anotherWindow.document.write('<html><body onload="window.print()">' + printContent + '</body></html>');
         anotherWindow.document.head.innerHTML = css;
         anotherWindow.document.close();
         setTimeout(function() {
            anotherWindow.close();
         }, 5);
  })
</script>

@endpush

