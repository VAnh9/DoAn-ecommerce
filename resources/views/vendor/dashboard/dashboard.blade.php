@extends('vendor.layouts.master')

@section('title')
  {{ $settings->site_name }} || Dashboard
@endsection

@section('content')

<section id="wsus__dashboard">
    <div class="container-fluid">
        @include('vendor.layouts.sidebar')
      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content">
            <div class="wsus__dashboard">
              <div class="row">
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item red" href="{{ route('vendor.orders') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <p>today's order</p>
                    <h5 class="text-white">{{ $todayOrders }}</h5>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item orange" href="{{ route('vendor.orders') }}">
                    <i class="fas fa-shipping-fast"></i>
                    <p>todays pending order</p>
                    <h5 class="text-white">{{ $todayPendingOrders }}</h5>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item blue" href="{{ route('vendor.orders') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <p>total order</p>
                    <h5 class="text-white">{{ $totalOrders }}</h5>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item yellow" href="{{ route('vendor.orders') }}">
                    <i class="fas fa-shipping-fast"></i>
                    <p>total pending order</p>
                    <h5 class="text-white">{{ $totalPendingOrders }}</h5>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item green" href="{{ route('vendor.orders') }}">
                    <i class="fas fa-box"></i>
                    <p>total complete order</p>
                    <h5 class="text-white">{{ $totalCompleteOrders }}</h5>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item green" href="{{ route('vendor.products.index') }}">
                    <i class="fas fa-box-open"></i>
                    <p>total product</p>
                    <h5 class="text-white">{{ $totalProducts }}</h5>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item blue" href="javascript:;">
                    <i class="fas fa-wallet"></i>
                    <p>today's earnings</p>
                    <h5 class="text-white">{{ $settings->currency_icon }}{{ $todayEarning }}</h5>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item sky" href="javascript:;">
                    <i class="fas fa-wallet"></i>
                    <p>this months earnings</p>
                    <h5 class="text-white">{{ $settings->currency_icon }}{{ $monthEarning }}</h5>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item sky" href="javascript:;">
                    <i class="fas fa-wallet"></i>
                    <p>this years earnings</p>
                    <h5 class="text-white">{{ $settings->currency_icon }}{{ $yearEarning }}</h5>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item sky" href="javascript:;">
                    <i class="fas fa-wallet"></i>
                    <p>total earnings</p>
                    <h5 class="text-white">{{ $settings->currency_icon }}{{ $totalEarning }}</h5>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item purple" href="{{ route('vendor.reviews.index') }}">
                    <i class="fas fa-star"></i>
                    <p>reviews</p>
                    <h5 class="text-white">{{ $review }}</h5>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item orange" href="{{ route('vendor.profile') }}">
                    <i class="fas fa-user-shield"></i>
                    <p>profile</p>
                    <h5 class="text-white">-</h5>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item purple" href="{{ route('vendor.shop-profile.index') }}">
                    <i class="far fa-store"></i>
                    <p>Shop profile</p>
                    <h5 class="text-white">-</h5>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


@endsection
