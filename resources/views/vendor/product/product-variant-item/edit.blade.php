@extends('vendor.layouts.master')

@section('content')


  <section id="wsus__dashboard">
    <div class="container-fluid">
        @include('vendor.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <h4>Edit Variant Item</h4>
            <div class="text-end mb-2">
              <a href="{{ route('vendor.product-variant-item.index', ['productId' => $variantItem->productVariant->product_id, 'variantId' => $variantItem->productVariant->id]) }}" class="btn btn-secondary rounded-pill">Back</a>
            </div>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                <form action="{{ route('vendor.product-variant-item.update', $variantItem->id) }}" method="POST">
                  @csrf
                  @method('PUT')

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label>Variant Name</label>
                    <input type="text"  name="variant_name" class="form-control" value="{{ $variantItem->productVariant->name }}" readonly>
                    @if ($errors->has('variant_name'))
                      <code>{{ $errors->first('variant_name') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label>Item Name</label>
                    <input type="text"  name="item_name" class="form-control" value="{{ $variantItem->name }}">
                    @if ($errors->has('item_name'))
                      <code>{{ $errors->first('item_name') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label>Price <code>(Set 0 for make it free)</code></label>
                    <input type="text"  name="price" class="form-control" value="{{ $variantItem->price }}">
                    @if ($errors->has('price'))
                      <code>{{ $errors->first('price') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="inputState">Is Default</label>
                     <select name="is_default" id="inputState" class="form-control">
                        <option value="">Select</option>
                        <option {{ $variantItem->is_default == 1 ? 'selected' : '' }} value="1">Yes</option>
                        <option {{ $variantItem->is_default == 0 ? 'selected' : '' }} value="0">No</option>
                     </select>
                     @if ($errors->has('is_default'))
                      <code>{{ $errors->first('is_default') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="inputState">Status</label>
                     <select name="status" id="inputState" class="form-control">
                        <option {{ $variantItem->status == 1 ? 'selected' : '' }} value="1">Active</option>
                        <option {{ $variantItem->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
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
    </div>
  </section>



@endsection

@push('scripts')

@endpush

