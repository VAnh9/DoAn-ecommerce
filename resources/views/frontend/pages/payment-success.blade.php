@extends('frontend.layouts.master')
@section('title')
  {{ $settings->site_name }} || Payment
@endsection

@section('content')

    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
      <div class="wsus_breadcrumb_overlay">
          <div class="container">
              <div class="row">
                  <div class="col-12">
                      <h4>payment</h4>
                      <ul>
                          <li><a href="{{ url('/') }}">home</a></li>
                          <li><a href="javascript:;">payment</a></li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!--============================
      BREADCRUMB END
  ==============================-->


  <!--============================
      PAYMENT PAGE START
  ==============================-->
  <section id="wsus__cart_view">
      <div class="container">
          <div class="wsus__pay_info_area">
            <div class="row payment_success_wrapper">
              <div class="payment_success_card">
                <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                  <i class="checkmark">✓</i>
                </div>
                  <h1>Success</h1>
                  <p>Thank you for your order. Your order will be delivered to you soon!</p>
                  <a href="{{ route('home') }}" class="btn btn-primary mt-3">Continue Shopping</a>
                </div>
            </div>
          </div>
      </div>
  </section>
  <!--============================
      PAYMENT PAGE END
  ==============================-->

@endsection

