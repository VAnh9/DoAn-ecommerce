@php
  $footerInfo = \App\Models\FooterInfo::first();
  $footerSocialLinks = \App\Models\FooterSocialLink::where('status', 1)->get();
  $footerGridTwoLinks = \App\Models\FooterGridTwo::where('status', 1)->get();
  $footerGridThreeLinks = \App\Models\FooterGridThree::where('status', 1)->get();
  $footerTitle = \App\Models\FooterTitle::first();
@endphp
<footer class="footer_2">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xl-3 col-sm-7 col-md-6 col-lg-3">
                <div class="wsus__footer_content">
                    <a class="wsus__footer_2_logo" href="javascript:;">
                        <img src="{{ asset(@$footerInfo->logo) }}" alt="logo">
                    </a>
                    <a class="action" href="callto:{{@$footerInfo->phone}}"><i class="fas fa-phone-alt"></i>
                        {{ @$footerInfo->phone }}</a>
                    <a class="action" href="mailto:{{ @$footerInfo->email }}"><i class="far fa-envelope"></i>
                        {{ @$footerInfo->email }}</a>
                    <p><i class="fal fa-map-marker-alt"></i> {{ @$footerInfo->address }}</p>
                    <ul class="wsus__footer_social">
                      @foreach ($footerSocialLinks as $link )
                        <li><a class="facebook" href="{{ $link->url }}"><i class="{{ $link->icon }}"></i></a></li>
                      @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-5 col-md-4 col-lg-2">
                <div class="wsus__footer_content">
                    <h5>{{ $footerTitle->footer_grid_two_title }}</h5>
                    <ul class="wsus__footer_menu">
                      @foreach ($footerGridTwoLinks as $link )
                        <li><a href="{{ $link->url }}"><i class="fas fa-caret-right"></i>{{ $link->name }}</a></li>
                      @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-5 col-md-4 col-lg-2">
                <div class="wsus__footer_content">
                    <h5>{{ $footerTitle->footer_grid_three_title }}</h5>
                    <ul class="wsus__footer_menu">
                      @foreach ($footerGridThreeLinks as $link )
                        <li><a href="{{ $link->url }}"><i class="fas fa-caret-right"></i>{{ $link->name }}</a></li>
                      @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-4 col-sm-7 col-md-8 col-lg-5">
                <div class="wsus__footer_content wsus__footer_content_2">
                    <h3>Subscribe To Our Newsletter</h3>
                    <p>Get all the latest information on Events, Sales and Offers.
                        Get all the latest information on Events.</p>
                    <form action="" method="POST" id="newsletter-form">
                      @csrf
                        <input type="text" placeholder="Email" name="email" class="newsletter_email"/>
                        <button type="submit" class="common_btn subscribe-btn">subscribe</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row justify-content-between mt-5">
          <div class="text-white text-center">{{ @$footerInfo->copyright }}</div>
        </div>
    </div>
    {{-- <div class="wsus__footer_bottom">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__copyright d-flex justify-content-center">
                        <p>Copyright © 2021 Sazao shop. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</footer>


