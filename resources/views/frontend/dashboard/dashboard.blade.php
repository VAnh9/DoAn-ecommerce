@extends('frontend.dashboard.layouts.master')
@section('title')
  {{ $settings->site_name }} || Dashboard
@endsection
@section('content')

<section id="wsus__dashboard">
    <div class="container-fluid">
        @include('frontend.dashboard.layouts.sidebar')
      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content">
            <div class="wsus__dashboard">
              <div class="row">
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item red" href="{{ route('user.orders.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <p>total order: {{ $totalOrder }}</p>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item blue" href="{{ route('user.orders.index') }}">
                    <i class="fas fa-shipping-fast"></i>
                    <p>pending order: {{ $pendingOrder }}</p>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item green" href="{{ route('user.orders.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <p>complete order: {{ $deliveredOrder }}</p>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item sky" href="{{ route('user.review.index') }}">
                    <i class="fas fa-star"></i>
                    <p>review: {{ $review }}</p>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a target="_blank" class="wsus__dashboard_item blue" href="{{ route('user.wishlist.index') }}">
                    <i class="far fa-heart"></i>
                    <p>wishlist: {{ $wishlist }}</p>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item orange" href="{{ route('user.profile') }}">
                    <i class="fas fa-user-shield"></i>
                    <p>profile</p>
                  </a>
                </div>
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item purple" href="{{ route('user.address.index') }}">
                    <i class="fal fa-map-marker-alt"></i>
                    <p>address</p>
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
