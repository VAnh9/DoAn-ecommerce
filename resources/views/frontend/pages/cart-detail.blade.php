@extends('frontend.layouts.master')
@section('title')
  {{ $settings->site_name }} || Cart Details
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
                      <h4>cart View</h4>
                      <ul>
                          <li><a href="{{ url('/') }}">home</a></li>
                          <li><a href="#">product</a></li>
                          <li><a href="#">cart view</a></li>
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
      CART VIEW PAGE START
  ==============================-->
  <section id="wsus__cart_view">
      <div class="container" id="cart_view_wrapper">
        @if (count($cartItem) > 0)
          <div class="row">
            <div class="col-xl-9">
                <div class="wsus__cart_list">
                    <div class="table-responsive">
                        <table>
                            <tbody>
                                <tr class="d-flex">
                                    <th class="wsus__pro_img">
                                        product item
                                    </th>

                                    <th class="wsus__pro_name">
                                        product details
                                    </th>

                                    <th class="wsus__pro_tk" style="width: 170px">
                                        price
                                    </th>

                                    <th class="wsus__pro_select">
                                      quantity
                                    </th>

                                    <th class="wsus__pro_tk">
                                        total
                                    </th>

                                    <th class="wsus__pro_icon">
                                        <a href="#" class="common_btn clear_cart">clear cart</a>
                                    </th>
                                </tr>

                                @foreach ($cartItem as $item )
                                  <tr class="d-flex">
                                      <td class="wsus__pro_img">
                                        <a href="{{ route('product-detail', $item->options->slug) }}">
                                          <img src="{{ asset($item->options->image) }}" alt="product" class="img-fluid w-100">
                                        </a>
                                      </td>

                                      <td class="wsus__pro_name">
                                        <p><a href="{{ route('product-detail', $item->options->slug) }}">{!! $item->name !!}</a></p>
                                        @foreach ($item->options->variants as $key => $variant )
                                          <span>{{$key}}: {{ $variant['name'] }} {{ $variant['price'] > 0 ? ' ('.$settings->currency_icon.$variant['price'].')' : ''}}</span>
                                        @endforeach
                                      </td>

                                      <td class="wsus__pro_tk" style="width: 170px">
                                        <h6>{{ $settings->currency_icon.$item->price }}</h6>
                                      </td>

                                      <td class="wsus__pro_select">
                                        <div class="select_product_qty">
                                          <button class="btn_sub">-</button>
                                          <input class="input_qty" data-rowId={{ $item->rowId }} type="text" min="1" max="100" value="{{ $item->qty }}">
                                          <button class="btn_add">+</button>
                                        </div>
                                      </td>

                                      <td class="wsus__pro_tk">
                                        <h6 id="{{ $item->rowId }}">{{ $settings->currency_icon.($item->price + $item->options->variants_total_price) * $item->qty }}</h6>
                                      </td>

                                      <td class="wsus__pro_icon">
                                          <a href="{{ route('cart.remove-product', $item->rowId) }}" class="delete_product" data-rowid="{{$item->rowId}}"><i class="far fa-times"></i></a>
                                      </td>
                                  </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                    <h6>total cart</h6>
                    <p>subtotal: <span id="sub_total">{{ $settings->currency_icon }}{{ getCartToTalPrice() }}</span></p>
                    <p>coupon(-): <span id="discount">{{ $settings->currency_icon }}{{ getDiscountPrice() }}</span></p>
                    <p class="total"><span>total:</span> <span id="total">{{ $settings->currency_icon }}{{ getPriceAfterApplyDiscount() }}</span></p>

                    <form id="coupon_form">
                        <input type="text" name="coupon_code" placeholder="Coupon Code" value="{{ session()->has('coupon') ? session()->get('coupon')['coupon_code'] : '' }}">
                        <button type="submit" class="common_btn">apply</button>
                    </form>
                    <a class="common_btn mt-4 w-100 text-center" href="{{ route('user.checkout') }}">checkout</a>
                    <a class="common_btn mt-1 w-100 text-center" href="{{ route('home')}}"><i
                            class="fab fa-shopify"></i> Keep Shopping</a>
                </div>
            </div>
          </div>
        @else
          <div class="row">
            <div class="col-sm-12 text-center empty-page mb-5">
            <img src="{{ asset('uploads/cart-empty.png') }}" width="130" height="130" class="img-fluid mb-4 mr-3">
            {{-- <img src="{{ asset('uploads/bag.svg') }}" alt="empty cart" class="img-fluid mb-4"> --}}
            <h2>Your shopping cart is empty!</h2>
            <p class="mb-3 pb-1">You have no items in your shopping cart.</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Continue shopping</a>
            </div>
          </div>
        @endif
      </div>
  </section>


  <section id="wsus__single_banner">
      <div class="container">
          <div class="row">
            @if ($cartPageBanner->banner_one->status == 1)
              <div class="col-xl-6 col-lg-6">
                  <div class="wsus__single_banner_content">
                      <div class="wsus__single_banner_img">
                          <img src="{{ asset($cartPageBanner->banner_one->banner_image) }}" alt="banner" class="img-fluid w-100">
                      </div>
                      <div class="wsus__single_banner_text">
                          <h6>sell on <span>35% off</span></h6>
                          <h3>smart watch</h3>
                          <a class="shop_btn" href="{{ $cartPageBanner->banner_one->banner_url }}">shop now</a>
                      </div>
                  </div>
              </div>
            @endif

            @if ($cartPageBanner->banner_two->status == 1)
              <div class="col-xl-6 col-lg-6">
                  <div class="wsus__single_banner_content single_banner_2">
                      <div class="wsus__single_banner_img">
                          <img src="{{ asset($cartPageBanner->banner_two->banner_image) }}" alt="banner" class="img-fluid w-100">
                      </div>
                      <div class="wsus__single_banner_text">
                          <h6>New Collection</h6>
                          <h3>Cosmetics</h3>
                          <a class="shop_btn" href="{{ $cartPageBanner->banner_two->banner_url }}">shop now</a>
                      </div>
                  </div>
              </div>
            @endif
          </div>
      </div>
  </section>
  <!--============================
        CART VIEW PAGE END
  ==============================-->

@endsection

@push('scripts')

<script>
  $(document).ready(function() {


    // increase product quantity
    $('.btn_add').on('click', function() {
      let input = $(this).siblings('.input_qty');
      let rowId = input.data('rowid');
      let quantity = parseInt(input.val()) + 1;
      input.val(quantity);

      $.ajax({
        url: "{{ route('cart.update-quantity') }}",
        method: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
          rowId: rowId,
          quantity: quantity,
        },
        success: function(data) {
          if(data.status == 'success') {
            let totalProductPrice = "{{ $settings->currency_icon }}" + data.totalPrice;
            let rowProductTotalPrice = '#' + rowId;
            $(rowProductTotalPrice).text(totalProductPrice);
            renderCartSubToTal();
            calculateCouponDiscount();
            toastr.success(data.message);
          }
          else if(data.status == 'error') {
            toastr.error(data.message);
          }
        },
        error: function(xhr, status, err) {
          console.log(err);
        }
      })
    })

    // decrease product quantity
    $('.btn_sub').on('click', function() {
      let input = $(this).siblings('.input_qty');
      let rowId = input.data('rowid');
      let quantity = parseInt(input.val()) - 1;



      if(quantity < 1) {
        quantity = 1;
        input.val(quantity);

        let route = `{{ route('cart.remove-product', ['rowId' => ':rowId'] ) }}`
        route = route.replace(':rowId', rowId);
        let rowDelete = $(this).closest('tr');

        deleteItem(route, rowDelete);
        return null;
      }

      input.val(quantity);

      $.ajax({
        url: "{{ route('cart.update-quantity') }}",
        method: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
          rowId: rowId,
          quantity: quantity,
        },
        success: function(data) {
          if(data.status == 'success') {
            let totalProductPrice = "{{ $settings->currency_icon }}" + data.totalPrice;
            let rowProductTotalPrice = '#' + rowId;
            $(rowProductTotalPrice).text(totalProductPrice);
            renderCartSubToTal();
            calculateCouponDiscount();
            toastr.success(data.message);
          }
          else if(data.status == 'error') {
            toastr.error(data.message);
          }
        },
        error: function(xhr, status, err) {
          console.log(err);
        }
      })


    })

    // clear cart
    $('.clear_cart').on('click', function(e) {
      e.preventDefault();

      Swal.fire({
        title: "Are you sure?",
        text: "This action will clear your cart!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, clear it!'
        }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
              type: 'DELETE',
              url: "{{ route('clear-cart') }}",
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function(data) {
                if(data.status == 'success') {
                  toastr.success(data.message);
                  getCartCount();

                  // window.location.reload();
                  $("#cart_view_wrapper").load(window.location + " #cart_view_wrapper");
                }
              },
              error: function(xhr, status, err) {
                  console.log(err);
              }
          })
        }
      })

    })

    // remove single product from cart
    $('.delete_product').on('click', function(e) {
      e.preventDefault();
      let route = $(this).attr('href');
      let rowDelete = $(this).closest('tr');

      deleteItem(route, rowDelete);

    })

  })

  // delete product and row
  function deleteItem(route, rowDelete) {
    Swal.fire({
        text: "Are you sure to remove this product?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
              type: 'DELETE',
              url: route,
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function(data) {
                if(data.status == 'success') {
                  renderCartSubToTal();
                  // window.location.reload();
                  rowDelete.remove();
                  getCartCount();
                  calculateCouponDiscount();
                  toastr.success(data.message);
                  if(data.countProduct == 0) {
                    {{ Illuminate\Support\Facades\Session::forget('coupon'); }}
                    $("#cart_view_wrapper").load(window.location + " #cart_view_wrapper");
                  }
                }
              },
              error: function(xhr, status, err) {
                  console.log(err);
              }
          })
        }
      })
  }


  // get cart count
  function getCartCount() {
    $.ajax({
      method: 'GET',
      url: "{{ route('cart-count') }}",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function(data) {
        $('#cart-count').text(data);
      },
      error: function(xhr, status, err) {
        console.log(err);
      }
    })
  }


  // get sub total cart price
  function renderCartSubToTal() {
    $.ajax({
      method: 'GET',
      url: "{{ route('cart.sidebar-product-total') }}",
      success: function(data) {
        $('#sub_total').text("{{$settings->currency_icon}}" + data);
      },
      error: function(xhr, status, err) {
        console.log(err);
      }
    })
  }

  // apply coupon on cart
  $('#coupon_form').on('submit', function(e) {
    e.preventDefault();
    let formData = $(this).serialize();
    $.ajax({
      method: 'GET',
      url: "{{ route('apply-coupon') }}",
      data: formData,
      success: function(data) {
        if(data.status == 'error') {
          toastr.error(data.message);
        }
        else if(data.status == 'success') {
          calculateCouponDiscount();
          toastr.success(data.message);
        }
      },
      error: function(xhr, status, err) {
        console.log(err);
      }
    })
  })

  // calculate total price after apply coupon and assign value
  function calculateCouponDiscount() {
    $.ajax({
      method: 'GET',
      url: "{{ route('coupon-calculation') }}",
      success: function(data) {
        if(data.status == 'success') {
          $('#discount').text("{{ $settings->currency_icon }}" + data.discount);
          $('#total').text("{{ $settings->currency_icon }}" + data.priceAfterDiscount);
        }
      },
      error: function(xhr, status, err) {
        console.log(err);
      }
    })
  }


</script>

@endpush
