<header>
    <div class="container">
        <div class="row">
            <div class="col-2 col-md-1 d-lg-none">
                <div class="wsus__mobile_menu_area">
                    <span class="wsus__mobile_menu_icon"><i class="fal fa-bars"></i></span>
                </div>
            </div>
            <div class="col-xl-2 col-7 col-md-8 col-lg-2 d-flex align-items-center">
                <div class="wsus_logo_area">
                    <a class="wsus__header_logo" style="width: 85%" href="{{ route('home') }}">
                        <img src="{{ asset( $logoSettings->logo )}}" alt="logo" class="img-fluid" style="width: 100%; vertical-align: baseline ">
                    </a>
                </div>
            </div>
            <div class="col-xl-5 col-md-6 col-lg-4 d-none d-lg-block">
                <div class="wsus__search">
                    <form action="{{ route('products.index') }}" method="GET">
                        <input type="text" placeholder="Search..." name="search" value="{{ request()->search }}">
                        <button type="submit"><i class="far fa-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="col-xl-5 col-3 col-md-3 col-lg-6">
                <div class="wsus__call_icon_area">
                    <div class="wsus__call_area">
                        <div class="wsus__call">
                            <i class="fas fa-user-headset"></i>
                        </div>
                        <div class="wsus__call_text">
                            <p>{{ $settings->contact_email }}</p>
                            <p>{{ $settings->contact_phone }}</p>
                        </div>
                    </div>
                    <ul class="wsus__icon_area">
                      @php
                        $role = Auth::check() ? auth()->user()->role : 'user';
                      @endphp
                        <li>
                          <a class="" href="{{ route("$role.messages.index") }}"><i class="fal fa-comment-dots"></i>
                            <span id="message-count">{{ Auth::check() ? \App\Models\Chat::where(['receiver_id' => auth()->user()->id, 'seen' => 0 ])->count() : 0 }}</span>
                          </a>
                        </li>
                        <li><a href="{{ route('user.wishlist.index') }}"><i class="fal fa-heart"></i><span id="wishlist-count">{{ Auth::check() ? \App\Models\Wishlist::where('user_id', auth()->user()->id)->count() : 0 }}</span></a></li>
                        <li><a class="wsus__cart_icon" href="javascript:;"><i
                                    class="fal fa-shopping-bag"></i><span id="cart-count">{{ Cart::content()->count() }}</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="wsus__mini_cart">
        <h4>shopping cart <span class="wsus_close_mini_cart"><i class="far fa-times"></i></span></h4>
        <ul class="mini_cart_wrapper">
          @foreach (Cart::content() as $product )
            <li id="mini_cart_{{$product->rowId}}">
                <div class="wsus__cart_img">
                    <a href="{{ route('product-detail', $product->options->slug) }}"><img src="{{ asset($product->options->image) }}" alt="product" class="img-fluid w-100"></a>
                    <a class="wsis__del_icon remove_sidebar_product" data-rowid="{{ $product->rowId }}" href="javascript:;"><i class="fas fa-minus-circle"></i></a>
                </div>
                <div class="wsus__cart_text">
                    <a class="wsus__cart_title" href="{{ route('product-detail', $product->options->slug) }}">{{ $product->name }}</a>
                    <p>{{ $settings->currency_icon }}{{$product->price}}</p>
                    <small>Variants total: {{ $settings->currency_icon }}{{ $product->options->variants_total_price }}</small>
                    <br>
                    <small>Qty: {{ $product->qty }}</small>
                </div>
            </li>

          @endforeach

          @if (Cart::content()->count() == 0)
            <li class="text-center">Your shopping cart is empty!</li>
          @endif
        </ul>

        <div class="mini_cart_actions {{ Cart::content()->count() == 0 ? 'd-none' : ''}}">
          <h5>sub total <span id="mini_cart_subtotal">{{$settings->currency_icon}}{{getCartToTalPrice()}}</span></h5>
          <div class="wsus__minicart_btn_area">
              <a class="common_btn" href="{{ route('cart-details') }}">view cart</a>
              <a class="common_btn" href="{{ route('user.checkout') }}">checkout</a>
          </div>
        </div>
    </div>

</header>

