@extends('vendor.layouts.master')

@section('content')


  <section id="wsus__dashboard">
    <div class="container-fluid">
        @include('vendor.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <h4>Create Variant Item</h4>
            <div class="text-end mb-2">
              <a href="{{ route('vendor.product-variant-item.index', ['productId' => $variant->product_id, 'variantId' => $variant->id]) }}" class="btn btn-secondary rounded-pill">Back</a>
            </div>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                <form action="{{ route('vendor.product-variant-item.store') }}" method="POST">
                  @csrf
                  <div class="form-group" style="margin-bottom: 1rem">
                    <input type="hidden"  name="variant_id" class="form-control" value="{{ $variant->id }}">
                  </div>

                  <div class="form-group" style="margin-bottom: 1rem">
                    <input type="hidden"  name="product_id" class="form-control" value="{{ $variant->product_id }}">
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label>Variant Name</label>
                    <input type="text"  name="variant_name" class="form-control" value="{{ $variant->name }}" readonly>
                    @if ($errors->has('variant_name'))
                      <code>{{ $errors->first('variant_name') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label>Item Name</label>
                    <input type="text"  name="item_name" class="form-control" value="{{ old('item_name') }}">
                    @if ($errors->has('item_name'))
                      <code>{{ $errors->first('item_name') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label>Price ({{ $settings->currency_icon }})<code>(Set 0 for make it free)</code></label>
                    <input type="text"  name="price" class="form-control" value="{{ old('price') }}">
                    @if ($errors->has('price'))
                      <code>{{ $errors->first('price') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="inputState">Is Default</label>
                     <select name="is_default" id="inputState" class="form-control">
                        <option value="">Select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                     </select>
                     @if ($errors->has('is_default'))
                      <code>{{ $errors->first('is_default') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="inputState">Status</label>
                     <select name="status" id="inputState" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                     </select>
                     @if ($errors->has('status'))
                      <code>{{ $errors->first('status') }}</code>
                    @endif
                  </div>

                  <button type="submit" class="btn btn-primary">Create</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



@endsection

@push('scripts')

@endpush

