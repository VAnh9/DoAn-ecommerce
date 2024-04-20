@extends('frontend.layouts.master')
@section('title')
  {{ $settings->site_name }} || Flash Sale
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
                        <h4>Flash Sale</h4>
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="javascript:;">Flash Sale</a></li>
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
          DAILY DEALS DETAILS START
      ==============================-->
    <section id="wsus__daily_deals">
        <div class="container">
            <div class="wsus__offer_details_area">
                <div class="row">
                  @if ($flashsalePageBanner->banner_one->status == 1)
                    <div class="col-xl-6 col-md-6">
                        <div class="wsus__offer_details_banner">
                            <img src="{{ asset($flashsalePageBanner->banner_one->banner_image)}}" alt="offrt img" class="img-fluid w-100">
                            <div class="wsus__offer_details_banner_text">
                                <p>apple watch</p>
                                <span>up 50% 0ff</span>
                                <p>for all poduct</p>
                                <p><b>today only</b></p>
                            </div>
                        </div>
                    </div>
                  @endif

                  @if ($flashsalePageBanner->banner_two->status == 1)
                    <div class="col-xl-6 col-md-6">
                        <div class="wsus__offer_details_banner">
                            <img src="{{ asset($flashsalePageBanner->banner_two->banner_image)}}" alt="offrt img" class="img-fluid w-100">
                            <div class="wsus__offer_details_banner_text">
                                <p>xiaomi power bank</p>
                                <span>up 37% 0ff</span>
                                <p>for all poduct</p>
                                <p><b>today only</b></p>
                            </div>
                        </div>
                    </div>
                  @endif
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="wsus__section_header rounded-0">
                            <h3>flash sale</h3>
                            <div class="wsus__offer_countdown">
                                <span class="end_text">ends time :</span>
                                <div class="simply-countdown simply-countdown-one"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                  @php
                    $products = \App\Models\Product::withAvg('productReviews as review_rating', 'rating')
                      ->withCount('productReviews as review_count')
                      ->with(['productImageGalleries', 'category', 'variants', 'variants.productVariantItems'])
                      ->whereIn('id', $flashSaleItems)
                      ->orderBy('id', 'DESC')->paginate(8);
                  @endphp
                  @foreach ($products as $product )
                    <div class="col-xl-3 col-sm-6 col-lg-4">
                      <x-product-card :product="$product" />
                    </div>
                  @endforeach
                </div>
                <div class="mt-5">
                  @if ($products->hasPages())
                    {{ $products->links() }}
                  @endif
                </div>
            </div>
        </div>
    </section>
    <!--============================
          DAILY DEALS DETAILS END
      ==============================-->




@endsection



@push('scripts')
  <script>

    $(document).ready(function() {
      simplyCountdown('.simply-countdown-one', {
        year: {{ date('Y', strtotime($flashSaleDate->end_date)) }},
        month: {{ date('m', strtotime($flashSaleDate->end_date)) }},
        day: {{ date('d', strtotime($flashSaleDate->end_date)) }},
    });
    })
  </script>
@endpush
