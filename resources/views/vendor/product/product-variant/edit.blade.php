@extends('vendor.layouts.master')

@section('title')
  {{ $settings->site_name }} || Product Variant
@endsection

@section('content')


  <section id="wsus__dashboard">
    <div class="container-fluid">
        @include('vendor.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <h4>Edit Variant</h4>
            <div class="text-end mb-2">
              <a href="{{ route('vendor.product-variant.index', ['product' => $variant->product_id]) }}" class="btn btn-secondary rounded-pill">Back</a>
            </div>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                <form action="{{ route('vendor.product-variant.update', $variant->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label>Name</label>
                    <input type="text"  name="name" class="form-control" value="{{ $variant->name }}">
                    @if ($errors->has('name'))
                      <code>{{ $errors->first('name') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="inputState">Status</label>
                     <select name="status" id="inputState" class="form-control">
                        <option {{ $variant->status == 1 ? 'selected' : '' }} value="1">Active</option>
                        <option {{ $variant->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
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

