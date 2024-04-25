@extends('frontend.layouts.master')

@section('title')
  {{ $settings->site_name }} || Checkout
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
                    <h4>check out</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">check out</a></li>
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
    CHECK OUT PAGE START
==============================-->
<section id="wsus__cart_view">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="wsus__check_form">
                    <h5>Shipping Details <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">add
                            new address</a></h5>
                    <div class="row">
                      @foreach ($addresses as $address )
                        <div class="col-xl-6">
                          <div class="wsus__checkout_single_address">
                              <div class="form-check">
                                  <input class="form-check-input shipping_address" data-id="{{$address->id}}" type="radio" name="flexRadioDefault"
                                      id="flexRadioDefault1-{{$address->id}}" >
                                  <label class="form-check-label" for="flexRadioDefault1-{{$address->id}}">
                                      Select Address
                                  </label>
                              </div>
                              <ul>
                                  <li><span>Name :</span> {{ $address->name }}</li>
                                  <li><span>Phone :</span> {{ $address->phone }}</li>
                                  <li><span>Email :</span> {{ $address->email }}</li>
                                  <li><span>Country :</span> {{ $address->country }}</li>
                                  <li><span>City :</span> {{ $address->city }}</li>
                                  <li><span>District :</span> {{ $address->district }}</li>
                                  <li><span>Zip Code :</span> {{ $address->zip_code }}</li>
                                  <li><span>Address :</span> {{ $address->address }}</li>
                              </ul>
                          </div>
                        </div>
                      @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="wsus__order_details" id="sticky_sidebar">
                    <p class="wsus__product">shipping Methods</p>

                    @foreach ($shippingMethods as $method )
                      @if ($method->type === 'min_order_amount' && getCartToTalPrice() >= $method->min_cost)
                        <div class="form-check">
                            <input class="form-check-input shipping_method" type="radio" name="exampleRadios" id="exampleRadios-{{$method->id}}" data-cost="{{ $method->cost }}" value="{{ $method->id }}">
                            <label class="form-check-label" for="exampleRadios-{{$method->id}}">
                                {{ $method->name }}
                                <span>cost: ({{ $settings->currency_icon }}{{ $method->cost }})</span>
                            </label>
                        </div>
                      @elseif ($method->type === 'flat_cost')
                        <div class="form-check">
                          <input class="form-check-input shipping_method" type="radio" name="exampleRadios" id="exampleRadios-{{$method->id}}" data-cost="{{ $method->cost }}" value="{{ $method->id }}">
                          <label class="form-check-label" for="exampleRadios-{{$method->id}}">
                              {{ $method->name }}
                              <span>cost: ({{ $settings->currency_icon }}{{ $method->cost }})</span>
                          </label>
                        </div>
                      @endif
                    @endforeach

                    <div class="wsus__order_details_summery">
                        <p>subtotal: <span>{{ $settings->currency_icon }}{{ getCartToTalPrice() }}</span></p>
                        <p>shipping fee(+): <span id="shipping_fee">{{ $settings->currency_icon }}0</span></p>
                        <p>coupon(-): <span>{{ $settings->currency_icon }}{{ getDiscountPrice() }}</span></p>
                        <p><b>total:</b> <span><b id="total_price" data-price="{{getPriceAfterApplyDiscount()}}">{{ $settings->currency_icon }}{{ getPriceAfterApplyDiscount() }}</b></span></p>
                    </div>
                    <div class="terms_area">
                        <div class="form-check">
                            <input class="form-check-input terms_conditions" type="checkbox" value="" id="flexCheckChecked3"
                                checked>
                            <label class="form-check-label" for="flexCheckChecked3">
                                I have read and agree to the website <a target="_blank" href="{{ route('terms-and-conditions') }}">terms and conditions *</a>
                            </label>
                        </div>
                    </div>

                    <form action="" id="CheckoutForm">
                      <input type="hidden" name="shipping_method_id" readonly value="" id="shipping_method_id">
                      <input type="hidden" name="shipping_address_id" readonly value="" id="shipping_address_id">
                      <a href="" id="submitCheckoutForm" class="common_btn">Place Order</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="wsus__popup_address">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">add new address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="wsus__check_form p-3">
                      <form action="{{ route('user.checkout.address-create') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="wsus__check_single_form">
                                    <input type="text" name="name" placeholder="Name *" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="wsus__check_single_form">
                                  <input type="text" name="phone" placeholder="Phone *" value="{{ old('phone') }}">
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wsus__check_single_form">
                                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="wsus__check_single_form">
                                    <select class="select_2 country" name="country">
                                        <option value="">Country *</option>
                                        @foreach (config('settings.country_list') as $key => $country )
                                          <option {{ $country === old('country') ? 'selected' : '' }} value="{{ $country }}" data-id="{{$key}}">{{ $country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wsus__check_single_form">
                                  <select class="select_2 city" name="city">
                                    <option value="">City *</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wsus__check_single_form">
                                    <input type="text" name="district" placeholder="District" value="{{ old('district') }}">
                                </div>
                                  </div>
                            <div class="col-md-6">
                                <div class="wsus__check_single_form">
                                    <input type="text" name="zip" placeholder="Zip" value="{{ old('zip') }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="wsus__check_single_form">
                                    <input type="text" name="address" placeholder="Address * " value="{{ old('address') }}">
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="wsus__check_single_form">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--============================
    CHECK OUT PAGE END
==============================-->

@endsection

@push('scripts')

<script>
  $(document).ready(function() {

    // get cities from countries
    $('body').on('change', '.country', function() {

      let country = $(this).val();
      country = country.split(" ").join("");

      $.ajax({
        url: "https://countriesnow.space/api/v0.1/countries/cities",
        method: 'POST',
        data: {
          country: country
        },
        success: function(data) {

          $('.city').html('<option value="">City *</option>')
          $.each(data.data, function(i, item) {

           $('.city').append(`<option value="${item}">${item}</option>`)

          })
        },
        error: function(xhr, status, err) {
          console.log(err);
        }
      })

    })

    // uncheck all radio input when reload page and reload value
    $("input[type='radio']").prop('checked', false);
    $("#shipping_address_id").val("");
    $("#shipping_method_id").val("");

    // calculate price after apply shipping fee
    $('.shipping_method').on('click', function() {

      let shippingFee = $(this).data('cost');

      $('#shipping_method_id').val($(this).val());
      $('#shipping_fee').text("{{ $settings->currency_icon }}" + shippingFee);

      let totalPriceBeforeApplyShipping = $('#total_price').data('price');
      let totalPriceAfterApplyShipping = totalPriceBeforeApplyShipping + shippingFee;
      $('#total_price').text("{{ $settings->currency_icon }}" + totalPriceAfterApplyShipping);
    })

    // assign address id to input
    $('.shipping_address').on('click', function() {
      let addressId = $(this).data('id');
      $('#shipping_address_id').val(addressId);
    })

    // submit checkout form
    $('#submitCheckoutForm').on('click', function(e) {
      e.preventDefault();
      let shippingMethodId = $('#shipping_method_id').val();
      let addressId = $("#shipping_address_id").val();

      if(shippingMethodId == "") {
        toastr.error('Shipping method is required!');
      }
      else if(addressId == "") {
        toastr.error('Shipping address is required!');
      }
      else if(!$('.terms_conditions').prop('checked')) {
        toastr.error('You have to agree website terms and conditions!');
      }
      else {
        let formData = $('#CheckoutForm').serialize();
        $.ajax({
          method: 'POST',
          url: "{{ route('user.checkout.form-submit') }}",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: formData,
          beforeSend: function() {
            $('#submitCheckoutForm').html('<i class="fas fa-spinner fa-spin fa-1x"></i>')
          },
          success: function(data) {
            if(data.status == 'success') {
              $('#submitCheckoutForm').text('Place Order');

              // redirect to payment page
              window.location.href = data.redirect_url;
            }

          },
          error: function(xhr, status, err) {
            console.log(err);
          }
        })
      }

    })
  })
</script>

@endpush
