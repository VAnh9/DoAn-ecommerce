@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Shipping Rule</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Shipping Rule</h4>
                    <div class="card-header-action">
                      <a href="{{ route('admin.shipping-rule.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.shipping-rule.update', $shippingRule->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Name</label>
                        <input type="text"  name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $shippingRule->name }}">
                        @if ($errors->has('name'))
                          <code>{{ $errors->first('name') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Type</label>
                         <select name="type" id="inputState" class="form-control shipping-type @error('type') is-invalid @enderror">
                            <option {{ $shippingRule->type == 'flat_cost' ? 'selected' : '' }} value="flat_cost">Flat Cost</option>
                            <option {{ $shippingRule->type == 'min_order_amount' ? 'selected' : '' }} value="min_order_amount">Minimum Order Amount</option>
                         </select>
                         @if ($errors->has('type'))
                          <code>{{ $errors->first('type') }}</code>
                        @endif
                      </div>

                      <div class="form-group min_cost {{$shippingRule->type == 'flat_cost' ? 'd-none' : ''}}" style="margin-bottom: 1rem">
                        <label>Minimum Amount</label>
                        <input type="text"  name="min_cost" class="form-control @error('min_cost') is-invalid @enderror" value="{{ $shippingRule->min_cost }}">
                        @if ($errors->has('min_cost'))
                          <code>{{ $errors->first('min_cost') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Shipping Cost</label>
                        <input type="text"  name="cost" class="form-control @error('cost') is-invalid @enderror" value="{{ $shippingRule->cost }}">
                        @if ($errors->has('cost'))
                          <code>{{ $errors->first('cost') }}</code>
                        @endif
                      </div>


                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Status</label>
                         <select name="status" id="inputState" class="form-control ">
                            <option {{ $shippingRule->status == 1 ? 'selected' : '' }}  value="1">Active</option>
                            <option {{ $shippingRule->status == 0 ? 'selected' : '' }}  value="0">Inactive</option>
                         </select>
                         @if ($errors->has('status'))
                          <code>{{ $errors->first('status') }}</code>
                        @endif
                      </div>

                      <button type="submit" class="btn btn-primary">Update</button>
                    </form>
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
      $('body').on('change', '.shipping-type', function() {
        let value = $(this).val();

        if(value != 'min_order_amount') {
          $('.min_cost').addClass('d-none');
        }
        else {
          $('.min_cost').removeClass('d-none');
        }


      })
    })
  </script>

@endpush
