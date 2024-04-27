<div class="tab-pane fade example example4" id="v-pills-stripe" role="tabpanel" aria-labelledby="v-pills-home-tab">
    <div class="row">
        <div class="col-xl-12 m-auto">
            <div class="wsus__payment_area" id="card_wrapper">
                <form action="{{ route('user.stripe.payment') }}" method="POST" id="checkout-form">
                    @csrf
                    <input type="hidden" name="stripe_token" id="stripe-token-id">
                    <div id="card-element"></div>
                    <button type="button" onclick="createToken()" class="nav-link common_btn" id="pay-btn">Pay with Stripe (Pay in VND)</button>
                </form>
            </div>
        </div>
    </div>
</div>

@php
  $stripeSetting = \App\Models\StripeSetting::first();
@endphp

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>

<script>
  var stripe = Stripe("{{ $stripeSetting->client_id }}");
  var elements = stripe.elements();
  var cardElement = elements.create('card', {
    style: {
      base: {
        color: "#32325D",
        fontWeight: 500,
        fontFamily: "Inter, Open Sans, Segoe UI, sans-serif",
        fontSize: "16px",
        fontSmoothing: "antialiased",

        "::placeholder": {
          color: "#CFD7DF"
        }
      },
      invalid: {
        color: "#E25950"
      }
    }
  });
  cardElement.mount('#card-element');

  function createToken() {
    $('#pay-btn').prop('disabled', true);
    stripe.createToken(cardElement).then(function(result) {

      if(typeof result.error != 'undefined') {
        $('#pay-btn').prop('disabled', false);
        toastr.error(result.error.message);
      }

      // create token success
      if(typeof result.token != 'undefined') {
        $('#stripe-token-id').val(result.token.id);
        $('#checkout-form').submit();
      }
    })
  }

</script>

@endpush

<style>
.example.example4 {
  background-color: #f6f9fc;
}

.example.example4 * {
  font-family: Inter, Open Sans, Segoe UI, sans-serif;
  font-size: 16px;
  font-weight: 500;
}

.example.example4 form {
  max-width: 496px !important;
  padding: 0 15px;
}

.example.example4 form > * + * {
  margin-top: 20px;
}




.example.example4 .card-only {
  display: block;
}
.example.example4 .payment-request-available {
  display: none;
}


.example.example4 input, {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  outline: none;
  border-style: none;
  color: #fff;
}

.example.example4 input:-webkit-autofill {
  transition: background-color 100000000s;
  -webkit-animation: 1ms void-animation-out;
}

.example.example4 #card-element {
  padding: 10px;
  margin-bottom: 2px;
}

.example.example4 input {
  -webkit-animation: 1ms void-animation-out;
}

.example.example4 input::-webkit-input-placeholder {
  color: #9bacc8;
}

.example.example4 input::-moz-placeholder {
  color: #9bacc8;
}

.example.example4 input:-ms-input-placeholder {
  color: #9bacc8;
}


</style>
