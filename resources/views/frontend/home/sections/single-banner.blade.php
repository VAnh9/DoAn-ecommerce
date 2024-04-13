<section id="wsus__single_banner" class="wsus__single_banner_2">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="wsus__single_banner_content">
                  @if ($homepageBannerSectionTwo->banner_one->status == 1)
                    <div class="wsus__single_banner_img">
                        <img src="{{ asset($homepageBannerSectionTwo->banner_one->banner_image) }}" alt="banner" class="img-fluid w-100">
                    </div>
                    <div class="wsus__single_banner_text">
                        <h6>sell on <span>35% off</span></h6>
                        <h3>smart watch</h3>
                        <a class="shop_btn" href="{{ $homepageBannerSectionTwo->banner_one->banner_url }}">shop now</a>
                    </div>
                  @endif
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="wsus__single_banner_content single_banner_2">
                  @if ($homepageBannerSectionTwo->banner_two->status == 1)
                    <div class="wsus__single_banner_img">
                        <img src="{{ asset($homepageBannerSectionTwo->banner_two->banner_image) }}" alt="banner" class="img-fluid w-100">
                    </div>
                    <div class="wsus__single_banner_text">
                        <h6>New Collection</h6>
                        <h3>bicycle</h3>
                        <a class="shop_btn" href="{{ $homepageBannerSectionTwo->banner_two->banner_url }}">shop now</a>
                    </div>
                  @endif
                </div>
            </div>
        </div>
    </div>
</section>
