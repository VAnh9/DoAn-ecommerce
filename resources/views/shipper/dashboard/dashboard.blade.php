@extends('shipper.layouts.master')

@section('title')
  {{ $settings->site_name }} || Dashboard
@endsection

@section('content')

<section id="wsus__dashboard">
    <div class="container-fluid">
        @include('shipper.layouts.sidebar')
      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content">
            <div class="wsus__dashboard">
              <div class="row">
                  <div class="col-xl-2 col-6 col-md-4">
                    <a class="wsus__dashboard_item sky" href="{{ route('shipper.orders.index') }}">
                      <i class="fas fa-truck"></i>
                      <p>shipping order</p>
                      <h5 class="text-white">{{ $shippingOrder }}</h5>
                    </a>
                  </div>
                  <div class="col-xl-2 col-6 col-md-4" style="width: auto">
                    <a class="wsus__dashboard_item green" href="{{ route('shipper.orders.index') }}">
                      <i class="fas fa-truck"></i>
                      <p>shipped order successfully</p>
                      <h5 class="text-white">{{ $shippedOrder }}</h5>
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
