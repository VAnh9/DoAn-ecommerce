<section id="wsus__hot_deals" class="wsus__hot_deals_2">
    <div class="container">
        <div class="wsus__hot_large_item">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__section_header justify-content-start">
                        <div class="monthly_top_filter2 mb-1">
                            <button class="active auto_click" data-filter=".new_arrival">New Arrival</button>
                            <button data-filter=".featured_product">Featured</button>
                            <button data-filter=".top_product">Top Products</button>
                            <button data-filter=".best_product">Best Products</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row grid2">
              @foreach ($productsBasedType as $key => $products)
                @foreach ($products as $product )
                  <div class="col-xl-3 col-sm-6 col-lg-4 {{ @$key }}">
                    <x-product-card :product="$product" />
                  </div>
                @endforeach
              @endforeach
            </div>
        </div>



        <section id="wsus__single_banner" class="home_2_single_banner">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="wsus__single_banner_content banner_1">
                          @if ($homepageBannerSectionThree->banner_one->status == 1)
                            <div class="wsus__single_banner_img">
                                <img src="{{ asset($homepageBannerSectionThree->banner_one->banner_image) }}" alt="banner" class="img-fluid w-100">
                            </div>
                            <div class="wsus__single_banner_text">
                                <h6>sell on <span>35% off</span></h6>
                                <h3>smart watch</h3>
                                <a class="shop_btn" href="{{ $homepageBannerSectionThree->banner_one->banner_url }}">shop now</a>
                            </div>
                          @endif
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="wsus__single_banner_content single_banner_2">
                                  @if ($homepageBannerSectionThree->banner_two->status == 1)
                                    <div class="wsus__single_banner_img">
                                        <img src="{{ asset($homepageBannerSectionThree->banner_two->banner_image) }}" alt="banner" class="img-fluid w-100">
                                    </div>
                                    <div class="wsus__single_banner_text">
                                        <h6>sell on <span>35% off</span></h6>
                                        <h3>smart watch</h3>
                                        <a class="shop_btn" href="{{ $homepageBannerSectionThree->banner_two->banner_url }}">shop now</a>
                                    </div>
                                  @endif
                                </div>
                            </div>
                            <div class="col-12 mt-lg-4">
                                <div class="wsus__single_banner_content">
                                  @if ($homepageBannerSectionThree->banner_three->status == 1)
                                    <div class="wsus__single_banner_img">
                                        <img src="{{ asset($homepageBannerSectionThree->banner_three->banner_image) }}" alt="banner" class="img-fluid w-100">
                                    </div>
                                    <div class="wsus__single_banner_text">
                                        <h6>sell on <span>35% off</span></h6>
                                        <h3>smart watch</h3>
                                        <a class="shop_btn" href="{{ $homepageBannerSectionThree->banner_three->banner_url }}">shop now</a>
                                    </div>
                                  @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</section>


