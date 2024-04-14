@extends('frontend.layouts.master')

@section('title')
  {{ $settings->site_name }} || Product Detail
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
                    <h4>products details</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="#">product</a></li>
                        <li><a href="javascript:;">product details</a></li>
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
      PRODUCT DETAILS START
  ==============================-->
  <section id="wsus__product_details">
    <div class="container">
        <div class="wsus__details_bg">
            <div class="row">
                <div class="col-xl-4 col-md-5 col-lg-5" style="z-index: 200 !important">
                    <div id="sticky_pro_zoom">
                        <div class="exzoom hidden" id="exzoom">
                            <div class="exzoom_img_box">
                              @if ($product->video_link)
                                <a class="venobox wsus__pro_det_video" data-autoplay="true" data-vbtype="video"
                                    href="{{ $product->video_link }}">
                                    <i class="fas fa-play"></i>
                                </a>
                              @endif
                                <ul class='exzoom_img_ul'>
                                    <li><img class="zoom ing-fluid w-100" src="{{ asset($product->thumb_image) }}" alt="product"></li>
                                    @foreach ($product->productImageGalleries as $image )
                                      <li><img class="zoom ing-fluid w-100" src="{{ asset($image->image) }}" alt="product"></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="exzoom_nav"></div>
                            <p class="exzoom_btn">
                              <a href="javascript:void(0);" class="exzoom_prev_btn"> <i
                                      class="far fa-chevron-left"></i> </a>
                              <a href="javascript:void(0);" class="exzoom_next_btn"> <i
                                      class="far fa-chevron-right"></i> </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-md-7 col-lg-7">
                    <div class="wsus__pro_details_text">
                        <a class="title" href="javascript:;">{{ $product->name }}</a>
                        @if ($product->quantity > 0)
                          <p class="wsus__stock_area"><span class="in_stock">in stock</span> ({{$product->quantity}} item)</p>
                        @elseif ($product->quantity == 0)
                          <p class="wsus__stock_area"><span class="stock_out">stock out</span> ({{$product->quantity}} item)</p>
                        @endif
                        @if (checkDiscount($product))
                          <h4>{{ $settings->currency_icon }}{{ $product->offer_price }} <del>{{ $settings->currency_icon }}{{ $product->price }}</del></h4>
                        @else
                          <h4>{{ $settings->currency_icon }}{{ $product->price }}</h4>
                        @endif
                        <p class="review">
                          @php
                            $avgRating = round($product->productReviews()->avg('rating'));
                          @endphp
                          @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $avgRating)
                              <i class="fas fa-star"></i>
                            @else
                              <i class="far fa-star"></i>
                            @endif
                          @endfor
                          <span>({{ count($product->productReviews) }} review)</span>
                        </p>
                        <p class="description">{!! $product->short_description !!}</p>

                        @if (checkDiscount($product))
                          <div class="wsus_pro_hot_deals">
                            <h5>offer ending time : </h5>
                            <div class="simply-countdown simply-countdown-one"></div>
                          </div>
                        @endif

                        <form action="" class="shopping-cart-form">
                          <div class="wsus__selectbox">
                            <div class="row">
                              <input type="hidden" name="product_id" value="{{ $product->id }}">
                              @foreach ($product->variants as $variant )
                                @if ($variant->status == 1 && count($variant->productVariantItems) > 0)
                                  <div class="col-xl-6 col-sm-6 mb-2">
                                    <h5 class="mb-2">{{ $variant->name }}:</h5>
                                    <select class="select_2" name="variant_items[]">
                                      @foreach ($variant->productVariantItems as $variantItem )
                                        <option value="{{ $variantItem->id }}"
                                        {{ ($variantItem->is_default == 1 && $variantItem->status == 1 ) ? 'selected' : '' }}
                                        {{ ($variantItem->status == 0 ) ? 'disabled' : '' }}
                                        >
                                        {{ $variantItem->name }} {{ $variantItem->price > 0 ? ' ('.$settings->currency_icon.$variantItem->price.')' : '' }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                @endif
                              @endforeach
                            </div>
                          </div>

                          <div class="wsus__quentity">
                              <h5>quantity :</h5>
                              <div class="select_number">
                                  <input class="number_area" name="qty" type="text" min="1" max="100" value="1" />
                              </div>
                          </div>

                          <ul class="wsus__button_area">
                              <li><button type="submit" class="add_cart">add to cart</button></li>
                              <li><a class="buy_now" href="#">buy now</a></li>
                              <li><a href="javascript:;" class="wishlist-btn" data-id="{{ $product->id }}"><i class="fal fa-heart"></i></a></li>
                              {{-- <li><a href="#"><i class="far fa-random"></i></a></li> --}}
                          </ul>
                        </form>

                        <p class="brand_model"><span>brand :</span> {{ $product->brand->name }}</p>
                    </div>
                </div>
                <div class="col-xl-3 col-md-12 mt-md-5 mt-lg-0">
                    <div class="wsus_pro_det_sidebar" id="sticky_sidebar">
                        <ul>
                            <li>
                                <span><i class="fal fa-truck"></i></span>
                                <div class="text">
                                    <h4>Return Available</h4>
                                    <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                </div>
                            </li>
                            <li>
                                <span><i class="far fa-shield-check"></i></span>
                                <div class="text">
                                    <h4>Secure Payment</h4>
                                    <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                </div>
                            </li>
                            <li>
                                <span><i class="fal fa-envelope-open-dollar"></i></span>
                                <div class="text">
                                    <h4>Warranty Available</h4>
                                    <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                </div>
                            </li>
                        </ul>
                        <div class="wsus__det_sidebar_banner">
                            <img src="images/blog_1.jpg" alt="banner" class="img-fluid w-100">
                            <div class="wsus__det_sidebar_banner_text_overlay">
                                <div class="wsus__det_sidebar_banner_text">
                                    <p>Black Friday Sale</p>
                                    <h4>Up To 70% Off</h4>
                                    <a href="#" class="common_btn">shope now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__pro_det_description">
                    <div class="wsus__details_bg">
                        <ul class="nav nav-pills mb-3" id="pills-tab3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab7" data-bs-toggle="pill"
                                    data-bs-target="#pills-home22" type="button" role="tab"
                                    aria-controls="pills-home" aria-selected="true">Description</button>
                            </li>

                            @if (count($product->productAdditionalInformation) != 0)
                              <li class="nav-item" role="presentation">
                                  <button class="nav-link" id="pills-profile-tab7" data-bs-toggle="pill"
                                      data-bs-target="#pills-profile22" type="button" role="tab"
                                      aria-controls="pills-profile" aria-selected="false">Information</button>
                              </li>
                            @endif
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false">Vendor Info</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab2" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact2" type="button" role="tab"
                                    aria-controls="pills-contact2" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent4">
                            <div class="tab-pane fade  show active " id="pills-home22" role="tabpanel"
                                aria-labelledby="pills-home-tab7">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="wsus__description_area">
                                            {!! $product->long_description !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (count($product->productAdditionalInformation) != 0)
                              <div class="tab-pane fade" id="pills-profile22" role="tabpanel"
                                  aria-labelledby="pills-profile-tab7">
                                  <div class="row">
                                      <div class="col-12">
                                          <div class="wsus__pro_det_info">
                                              <h4>Additional Information</h4>
                                              @foreach ($product->productAdditionalInformation as $productInfo )
                                                @if ($productInfo->status == 1)
                                                <p><span>{{ $productInfo->name }}</span> {{ $productInfo->specifications }}</p>
                                                @endif
                                              @endforeach
                                          </div>
                                      </div>
                                  </div>
                              </div>
                            @endif

                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <div class="wsus__pro_det_vendor">
                                    <div class="row">
                                        <div class="col-xl-6 col-xxl-5 col-md-6">
                                            <div class="wsus__vebdor_img">
                                                <img src="{{ asset($product->vendor->banner) }}" alt="vensor" class="img-fluid w-100">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-xxl-7 col-md-6 mt-4 mt-md-0">
                                            <div class="wsus__pro_det_vendor_text">
                                                <h4>{{ $product->vendor->user->name }}</h4>
                                                <p class="rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <span>(41 review)</span>
                                                </p>
                                                <p><span>Store Name:</span>{{ $product->vendor->name }}</p>
                                                <p><span>Address:</span>{{ $product->vendor->address }}</p>
                                                <p><span>Phone:</span>{{ $product->vendor->phone }}</p>
                                                <p><span>mail:</span>{{ $product->vendor->email }}</p>
                                                <a href="vendor_details.html" class="see_btn">visit store</a>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="wsus__vendor_details">
                                                {!! $product->vendor->description !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Review section --}}
                            <div class="tab-pane fade" id="pills-contact2" role="tabpanel"
                                aria-labelledby="pills-contact-tab2">
                                <div class="wsus__pro_det_review">
                                    <div class="wsus__pro_det_review_single">
                                        <div class="row">
                                          @php
                                            $isBought = false;
                                            if(Auth::check()) {
                                              $orders = \App\Models\Order::where(['user_id' => Auth::user()->id, 'order_status' => 'delivered'])->get();
                                              foreach ($orders as $key => $order) {
                                                $existItem = $order->orderProducts()->where('product_id', $product->id)->first();
                                                if($existItem) {
                                                  $isBought = true;
                                                }
                                              }
                                            }
                                          @endphp
                                            <div class="{{ !$isBought ? 'col-md-12' : 'col-xl-8 col-lg-7' }}">
                                                <div class="wsus__comment_area">
                                                    <h4>Reviews <span>{{ count($reviews) }}</span></h4>
                                                    @foreach ($reviews as $review )
                                                      <div class="wsus__main_comment">
                                                          <div class="wsus__comment_img">
                                                              <img src="{{ asset($review->user->image) }}" alt="user"
                                                                  class="img-fluid w-100">
                                                          </div>
                                                          <div class="wsus__comment_text reply">
                                                              <h6>{{ $review->user->name }} <span>{{ $review->rating }} <i
                                                                          class="fas fa-star"></i></span></h6>
                                                              <span>{{ date('d M Y', strtotime($review->created_at)) }}</span>
                                                              <p>{{ $review->review }}</p>
                                                              <ul class="">
                                                                @if (count($review->productReviewGalleries) > 0)
                                                                  @foreach ($review->productReviewGalleries as $image )
                                                                    <li>
                                                                      <img src="{{ asset($image->image) }}" alt="product"
                                                                            class="img-fluid w-100">
                                                                    </li>
                                                                  @endforeach
                                                                @endif
                                                              </ul>

                                                          </div>
                                                      </div>
                                                    @endforeach

                                                    <div id="pagination">
                                                        @if ($reviews->hasPages())
                                                          {{ $reviews->withQueryString()->links() }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-5 mt-4 mt-lg-0">
                                              @if ($isBought)
                                                <div class="wsus__post_comment rev_mar" id="sticky_sidebar3">
                                                    <h4>write a Review</h4>
                                                    <form action="{{ route('user.review.create') }}" method="POST" enctype="multipart/form-data">
                                                      @csrf
                                                        <div class="rating d-flex align-items-center">
                                                          <span>select your rating : </span>
                                                          <div class="star-wrap">
                                                            <input type="radio" id="st-5" value="5" name="star_rate">
                                                            <label for="st-5"><i class="fas fa-star"></i></label>
                                                            <input type="radio" id="st-4" value="4" name="star_rate">
                                                            <label for="st-4"><i class="fas fa-star"></i></label>
                                                            <input type="radio" id="st-3" value="3" name="star_rate">
                                                            <label for="st-3"><i class="fas fa-star"></i></label>
                                                            <input type="radio" id="st-2" value="2" name="star_rate">
                                                            <label for="st-2"><i class="fas fa-star"></i></label>
                                                            <input type="radio" id="st-1" value="1" name="star_rate">
                                                            <label for="st-1"><i class="fas fa-star"></i></label>
                                                          </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <div class="col-xl-12">
                                                                    <div class="wsus__single_com">
                                                                        <textarea cols="3" rows="3" name="review"
                                                                            placeholder="Write your review"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="img_upload">
                                                            <div class="gallery">
                                                                <a class="cam" href="javascript:void(0)"><span><i
                                                                            class="fas fa-image"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <input type="hidden" name="vendor_id" value="{{ $product->vendor_id }}">
                                                        <button class="common_btn" type="submit">submit
                                                            review</button>
                                                    </form>
                                                </div>
                                              @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
  </section>
  <!--============================
      PRODUCT DETAILS END
  ==============================-->


  <!--============================
      RELATED PRODUCT START
  ==============================-->
  {{-- <section id="wsus__flash_sell">
      <div class="container">
          <div class="row">
              <div class="col-xl-12">
                  <div class="wsus__section_header">
                      <h3>Related Products</h3>
                      <a class="see_btn" href="#">see more <i class="fas fa-caret-right"></i></a>
                  </div>
              </div>
          </div>
          <div class="row flash_sell_slider">
              <div class="col-xl-3 col-sm-6 col-lg-4">
                  <div class="wsus__product_item">
                      <span class="wsus__new">New</span>
                      <span class="wsus__minus">-20%</span>
                      <a class="wsus__pro_link" href="product_details.html">
                          <img src="images/pro3.jpg" alt="product" class="img-fluid w-100 img_1" />
                          <img src="images/pro3_3.jpg" alt="product" class="img-fluid w-100 img_2" />
                      </a>
                      <ul class="wsus__single_pro_icon">
                          <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                      class="far fa-eye"></i></a></li>
                          <li><a href="#"><i class="far fa-heart"></i></a></li>
                          <li><a href="#"><i class="far fa-random"></i></a>
                      </ul>
                      <div class="wsus__product_details">
                          <a class="wsus__category" href="#">Electronics </a>
                          <p class="wsus__pro_rating">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star-half-alt"></i>
                              <span>(133 review)</span>
                          </p>
                          <a class="wsus__pro_name" href="#">hp 24" FHD monitore</a>
                          <p class="wsus__price">$159 <del>$200</del></p>
                          <a class="add_cart" href="#">add to cart</a>
                      </div>
                  </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-lg-4">
                  <div class="wsus__product_item">
                      <span class="wsus__new">New</span>
                      <a class="wsus__pro_link" href="product_details.html">
                          <img src="images/pro4.jpg" alt="product" class="img-fluid w-100 img_1" />
                          <img src="images/pro4_4.jpg" alt="product" class="img-fluid w-100 img_2" />
                      </a>
                      <ul class="wsus__single_pro_icon">
                          <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                      class="far fa-eye"></i></a></li>
                          <li><a href="#"><i class="far fa-heart"></i></a></li>
                          <li><a href="#"><i class="far fa-random"></i></a>
                      </ul>
                      <div class="wsus__product_details">
                          <a class="wsus__category" href="#">fashion </a>
                          <p class="wsus__pro_rating">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star-half-alt"></i>
                              <span>(17 review)</span>
                          </p>
                          <a class="wsus__pro_name" href="#">men's casual fashion watch</a>
                          <p class="wsus__price">$159 <del>$200</del></p>
                          <a class="add_cart" href="#">add to cart</a>
                      </div>
                  </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-lg-4">
                  <div class="wsus__product_item">
                      <span class="wsus__minus">-20%</span>
                      <a class="wsus__pro_link" href="product_details.html">
                          <img src="images/pro9.jpg" alt="product" class="img-fluid w-100 img_1" />
                          <img src="images/pro9_9.jpg" alt="product" class="img-fluid w-100 img_2" />
                      </a>
                      <ul class="wsus__single_pro_icon">
                          <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                      class="far fa-eye"></i></a></li>
                          <li><a href="#"><i class="far fa-heart"></i></a></li>
                          <li><a href="#"><i class="far fa-random"></i></a>
                      </ul>
                      <div class="wsus__product_details">
                          <a class="wsus__category" href="#">fashion </a>
                          <p class="wsus__pro_rating">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star-half-alt"></i>
                              <span>(120 review)</span>
                          </p>
                          <a class="wsus__pro_name" href="#">men's fashion sholder bag</a>
                          <p class="wsus__price">$159 <del>$200</del></p>
                          <a class="add_cart" href="#">add to cart</a>
                      </div>
                  </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-lg-4">
                  <div class="wsus__product_item">
                      <span class="wsus__new">New</span>
                      <span class="wsus__minus">-20%</span>
                      <a class="wsus__pro_link" href="product_details.html">
                          <img src="images/pro2.jpg" alt="product" class="img-fluid w-100 img_1" />
                          <img src="images/pro2_2.jpg" alt="product" class="img-fluid w-100 img_2" />
                      </a>
                      <ul class="wsus__single_pro_icon">
                          <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                      class="far fa-eye"></i></a></li>
                          <li><a href="#"><i class="far fa-heart"></i></a></li>
                          <li><a href="#"><i class="far fa-random"></i></a>
                      </ul>
                      <div class="wsus__product_details">
                          <a class="wsus__category" href="#">fashion </a>
                          <p class="wsus__pro_rating">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star-half-alt"></i>
                              <span>(72 review)</span>
                          </p>
                          <a class="wsus__pro_name" href="#">men's casual shoes</a>
                          <p class="wsus__price">$159 <del>$200</del></p>
                          <a class="add_cart" href="#">add to cart</a>
                      </div>
                  </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-lg-4">
                  <div class="wsus__product_item">
                      <span class="wsus__minus">-20%</span>
                      <a class="wsus__pro_link" href="product_details.html">
                          <img src="images/pro4.jpg" alt="product" class="img-fluid w-100 img_1" />
                          <img src="images/pro4_4.jpg" alt="product" class="img-fluid w-100 img_2" />
                      </a>
                      <ul class="wsus__single_pro_icon">
                          <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                      class="far fa-eye"></i></a></li>
                          <li><a href="#"><i class="far fa-heart"></i></a></li>
                          <li><a href="#"><i class="far fa-random"></i></a>
                      </ul>
                      <div class="wsus__product_details">
                          <a class="wsus__category" href="#">fashion </a>
                          <p class="wsus__pro_rating">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star-half-alt"></i>
                              <span>(17 review)</span>
                          </p>
                          <a class="wsus__pro_name" href="#">men's casual fashion watch</a>
                          <p class="wsus__price">$159 <del>$200</del></p>
                          <a class="add_cart" href="#">add to cart</a>
                      </div>
                  </div>
              </div>

          </div>
      </div>
  </section> --}}
  <!--============================
      RELATED PRODUCT END
  ==============================-->
@endsection


