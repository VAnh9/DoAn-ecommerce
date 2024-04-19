@extends('vendor.layouts.master')

@section('title')
  {{ $settings->site_name }} || Create Withdraw Request
@endsection

@section('content')


  <section id="wsus__dashboard">
    <div class="container-fluid">
        @include('vendor.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <h3><i class="far fa-wallet"></i> Create Withdraw Request</h3>
            <div class="text-end mb-2">
              <a href="{{ route('vendor.withdraw.index') }}" class="btn btn-secondary rounded-pill">Back</a>
            </div>
            <div class="wsus__dashboard_profile">
              <div class="row">
                <div class="wsus__dash_pro_area col-md-5 me-3">
                  <form action="{{ route('vendor.withdraw.store') }}" method="POST">
                    @csrf

                    <div class="form-group wsus__input " style="margin-bottom: 1rem">
                      <label for="">Withdraw Method</label>
                      <select name="withdraw_method" id="withdraw_method" class="form-control">
                        <option value="">Select</option>
                        @foreach ($withdrawMethods as $method )
                          <option value="{{ $method->id }}">{{ $method->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('withdraw_method'))
                        <code>{{ $errors->first('withdraw_method') }}</code>
                      @endif
                    </div>

                    <div class="form-group wsus__input " style="margin-bottom: 1rem">
                      <label for="">Withdraw Amount ({{ $settings->currency_icon }})</label>
                      <input type="text" name="withdraw_amount" class="form-control" />
                      @if ($errors->has('withdraw_amount'))
                        <code>{{ $errors->first('withdraw_amount') }}</code>
                      @endif
                    </div>

                    <div class="form-group wsus__input " style="margin-bottom: 1rem">
                      <label for="">Account Information</label>
                      <textarea name="account_info" id="" class="form-control" cols="30" rows="5"></textarea>
                      @if ($errors->has('account_info'))
                        <code>{{ $errors->first('account_info') }}</code>
                      @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                  </form>
                </div>

                <div class="wsus__dash_pro_area method_info col-md-5 d-none">
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



@endsection

@push('scripts')

<script>
  $(document).ready(function() {
    $('#withdraw_method').on('change', function(e) {

      let id = $(this).val();
      if(id) {
        $('.method_info').removeClass('d-none')
      }
      else {
        $('.method_info').addClass('d-none')
      }

      $.ajax({
        method: 'GET',
        url : "{{ route('vendor.withdraw.show', ':id') }}".replace(':id', id),
        success: function(data) {
          $('.method_info').html(`<h4 class="mb-4">Withdraw Method Information</h4>
                                  <div class="d-flex mb-3"><h5 class="me-2">Payout Range:</h5><p class="fs-5">{{ $settings->currency_icon }}${data.minimum_amount} - {{ $settings->currency_icon }}${data.maximum_amount}</p></div>
                                  <div class="d-flex mb-3"><h5 class="me-2">Withdraw Charge:</h5><p class="fs-5">${data.withdraw_charge}%</p></div>
                                  <h5 class="mb-2">Instructions:</h5>
                                  <p class="fs-5">${data.description}</p>
                                  `);
        },
        error: function(data) {
          console.log(data);
        }
      })
    })
  })
</script>

@endpush
