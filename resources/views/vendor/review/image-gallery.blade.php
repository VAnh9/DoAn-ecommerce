@extends('vendor.layouts.master')

@section('title')
  {{ $settings->site_name }} || Review Image Gallery
@endsection


@section('content')


  <section id="wsus__dashboard">
    <div class="container-fluid">
        @include('vendor.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <div class="d-flex justify-content-between mb-2">
              <h4><i class="far fa-store"></i>All Images</h4>
              <a href="{{ route('vendor.reviews.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                @foreach ($productReviewImages as $image )
                  <img src="{{ asset($image->image) }}" alt="image" style="height: auto; width: 200px" class="me-2">
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



@endsection



