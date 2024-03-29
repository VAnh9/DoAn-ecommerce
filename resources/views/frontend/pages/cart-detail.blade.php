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
      <div class="container">
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

                                      <th class="wsus__pro_tk">
                                          price
                                      </th>

                                      <th class="wsus__pro_select">
                                        quantity
                                      </th>

                                      <th class="wsus__pro_tk">
                                          total
                                      </th>

                                      <th class="wsus__pro_icon">
                                          <a href="#" class="common_btn">clear cart</a>
                                      </th>
                                  </tr>

                                  @foreach ($cartItem as $item )
                                    <tr class="d-flex">
                                        <td class="wsus__pro_img"><img src="{{ asset($item->options->image) }}" alt="product"
                                                class="img-fluid w-100">
                                        </td>

                                        <td class="wsus__pro_name">
                                          <p>{!! $item->name !!}</p>
                                          @foreach ($item->options->variants as $key => $variant )
                                            <span>{{$key}}: {{ $variant['name'] }} {{ $variant['price'] > 0 ? ' ('.$settings->currency_icon.$variant['price'].')' : ''}}</span>
                                          @endforeach
                                        </td>

                                        <td class="wsus__pro_tk">
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
                                            <a href="#"><i class="far fa-times"></i></a>
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
                      <p>subtotal: <span>$124.00</span></p>
                      <p>delivery: <span>$00.00</span></p>
                      <p>discount: <span>$10.00</span></p>
                      <p class="total"><span>total:</span> <span>$134.00</span></p>

                      <form>
                          <input type="text" placeholder="Coupon Code">
                          <button type="submit" class="common_btn">apply</button>
                      </form>
                      <a class="common_btn mt-4 w-100 text-center" href="check_out.html">checkout</a>
                      <a class="common_btn mt-1 w-100 text-center" href="product_grid_view.html"><i
                              class="fab fa-shopify"></i> go shop</a>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <section id="wsus__single_banner">
      <div class="container">
          <div class="row">
              <div class="col-xl-6 col-lg-6">
                  <div class="wsus__single_banner_content">
                      <div class="wsus__single_banner_img">
                          <img src="images/single_banner_2.jpg" alt="banner" class="img-fluid w-100">
                      </div>
                      <div class="wsus__single_banner_text">
                          <h6>sell on <span>35% off</span></h6>
                          <h3>smart watch</h3>
                          <a class="shop_btn" href="#">shop now</a>
                      </div>
                  </div>
              </div>
              <div class="col-xl-6 col-lg-6">
                  <div class="wsus__single_banner_content single_banner_2">
                      <div class="wsus__single_banner_img">
                          <img src="images/single_banner_3.jpg" alt="banner" class="img-fluid w-100">
                      </div>
                      <div class="wsus__single_banner_text">
                          <h6>New Collection</h6>
                          <h3>Cosmetics</h3>
                          <a class="shop_btn" href="#">shop now</a>
                      </div>
                  </div>
              </div>
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
            toastr.success(data.message);
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
            toastr.success(data.message);
          }
        },
        error: function(xhr, status, err) {
          console.log(err);
        }
      })


    })
  })
</script>

@endpush
