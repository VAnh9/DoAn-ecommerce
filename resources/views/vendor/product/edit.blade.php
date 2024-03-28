@extends('vendor.layouts.master')

@section('content')


  <section id="wsus__dashboard">
    <div class="container-fluid">
        @include('vendor.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <h4>Edit Product</h4>
            <div class="text-end mb-2">
              <a href="{{ route('vendor.products.index') }}" class="btn btn-secondary rounded-pill">Back</a>
            </div>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                <form action="{{ route('vendor.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="form-group" style="margin-bottom: 1rem">
                    <label for="">Preview</label> <br>
                    <img src="{{ asset($product->thumb_image) }}" width="200px" alt="">
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="">Thumb Image <span class="field-required">*</span></label>
                    <input type="file" id="" name="image" class="form-control">
                    @if ($errors->has('image'))
                      <code>{{ $errors->first('image') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="">Name <span class="field-required">*</span></label>
                    <input type="text" id="" name="name" class="form-control" value="{{ $product->name }}">
                    @if ($errors->has('name'))
                      <code>{{ $errors->first('name') }}</code>
                    @endif
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group wsus__input" style="margin-bottom: 1rem">
                        <label for="inputState">Category <span class="field-required">*</span></label>
                         <select name="category" id="inputState" class="form-control main-category">
                            <option value="">Select</option>
                            @foreach ($categories as $category )
                              <option class="{{ $category->status == 0 ? 'field-disabled' : '' }}" {{ $category->id == $product->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->status == 1 ? $category->name : $category->name.' (disabled)' }}</option>
                            @endforeach
                         </select>
                         @if ($errors->has('category'))
                          <code>{{ $errors->first('category') }}</code>
                        @endif
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group wsus__input" style="margin-bottom: 1rem">
                        <label for="inputState">Sub Category</label>
                         <select name="sub_category" id="inputState" class="form-control sub-category">
                            <option value="">Select</option>
                            @foreach ($subCategories as $subCategory )
                              <option class="{{ $subCategory->status == 0 ? 'field-disabled' : '' }}" {{ $subCategory->id == $product->sub_category_id ? 'selected' : '' }} value="{{ $subCategory->id }}">{{ $subCategory->status == 1 ? $subCategory->name : $subCategory->name.' (disabled)' }}</option>
                            @endforeach
                         </select>
                         @if ($errors->has('sub_category'))
                          <code>{{ $errors->first('sub_category') }}</code>
                        @endif
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group wsus__input" style="margin-bottom: 1rem">
                        <label for="inputState">Child Category</label>
                         <select name="child_category" id="inputState" class="form-control child-category">
                            <option value="">Select</option>
                            @foreach ($childCategories as $childCategory )
                              <option class="{{ $childCategory->status == 0 ? 'field-disabled' : '' }}" {{ $childCategory->id == $product->child_category_id ? 'selected' : '' }} value="{{ $childCategory->id }}">{{ $childCategory->status == 1 ? $childCategory->name : $childCategory->name.' (disabled)' }}</option>
                            @endforeach
                         </select>
                         @if ($errors->has('child_category'))
                          <code>{{ $errors->first('child_category') }}</code>
                        @endif
                      </div>
                    </div>
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="inputState">Brand <span class="field-required">*</span></label>
                     <select name="brand" id="inputState" class="form-control">
                        <option value="">Select</option>
                        @foreach ($brands as $brand )
                          <option {{ $brand->id == $product->brand_id ? 'selected' : '' }} value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                     </select>
                     @if ($errors->has('brand'))
                      <code>{{ $errors->first('brand') }}</code>
                    @endif
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group wsus__input" style="margin-bottom: 1rem">
                        <label for="">SKU</label>
                        <input type="text" id="" name="sku" class="form-control" value="{{ $product->sku }}">
                        @if ($errors->has('sku'))
                          <code>{{ $errors->first('sku') }}</code>
                        @endif
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group wsus__input" style="margin-bottom: 1rem">
                        <label for="">Price ({{ $settings->currency_icon }})<span class="field-required">*</span></label>
                        <input type="text" name="price" class="form-control" value="{{ $product->price }}">
                        @if ($errors->has('price'))
                          <code>{{ $errors->first('price') }}</code>
                        @endif
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group wsus__input" style="margin-bottom: 1rem">
                        <label for="">Stock Quantity <span class="field-required">*</span></label>
                        <input type="number" min="0" name="qty" class="form-control" value="{{ $product->quantity }}">
                        @if ($errors->has('qty'))
                          <code>{{ $errors->first('qty') }}</code>
                        @endif
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group wsus__input" style="margin-bottom: 1rem">
                        <label for="">Offer Price ({{ $settings->currency_icon }})</label>
                        <input type="text" name="offer_price" class="form-control" value="{{ $product->offer_price }}">
                        @if ($errors->has('offer_price'))
                          <code>{{ $errors->first('offer_price') }}</code>
                        @endif
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group wsus__input" style="margin-bottom: 1rem">
                        <label for="">Offer Start Date</label>
                        <input type="text" name="offer_start_date" class="form-control datepicker" value="{{ $product->offer_start_date }}">
                        @if ($errors->has('offer_start_date'))
                          <code>{{ $errors->first('offer_start_date') }}</code>
                        @endif
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group wsus__input" style="margin-bottom: 1rem">
                        <label for="">Offer End Date</label>
                        <input type="text" name="offer_end_date" class="form-control datepicker" value="{{ $product->offer_end_date  }}">
                        @if ($errors->has('offer_end_date'))
                          <code>{{ $errors->first('offer_end_date') }}</code>
                        @endif
                      </div>
                    </div>
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="">Short Description <span class="field-required">*</span></label>
                    <textarea name="short_description" class="form-control">{!! $product->short_description !!}</textarea>
                    @if ($errors->has('short_description'))
                      <code>{{ $errors->first('short_description') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="">Long Description <span class="field-required">*</span></label>
                    <textarea name="long_description" class="form-control summernote">{!! $product->long_description !!}</textarea>
                    @if ($errors->has('long_description'))
                      <code>{{ $errors->first('long_description') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="">Video Link</label>
                    <input type="text" name="video_link" class="form-control" value="{{ $product->video_link }}">
                    @if ($errors->has('video_link'))
                      <code>{{ $errors->first('video_link') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="inputState">Product Type</label>
                      <select name="product_type" id="inputState" class="form-control">
                        <option value="">Select</option>
                        <option {{ $product->product_type == 'new_arrival' ? 'selected' : '' }} value="new_arrival">New Arrival</option>
                        <option {{ $product->product_type == 'featured_product' ? 'selected' : '' }} value="featured_product">Featured</option>
                        <option {{ $product->product_type == 'top_product' ? 'selected' : '' }} value="top_product">Top Product</option>
                        <option {{ $product->product_type == 'best_product' ? 'selected' : '' }} value="best_product">Best Product</option>
                      </select>
                      @if ($errors->has('product_type'))
                      <code>{{ $errors->first('product_type') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="">Seo Title</label>
                    <input type="text" name="seo_title" class="form-control" value="{!! $product->seo_title !!}">
                    @if ($errors->has('seo_title'))
                      <code>{{ $errors->first('seo_title') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="">Seo Description</label>
                    <textarea name="seo_description" class="form-control">{!! $product->seo_description !!}</textarea>
                    @if ($errors->has('seo_description'))
                      <code>{{ $errors->first('seo_description') }}</code>
                    @endif
                  </div>

                  <div class="form-group wsus__input" style="margin-bottom: 1rem">
                    <label for="inputState">Status</label>
                     <select name="status" id="inputState" class="form-control">
                        <option {{ $product->status == 1 ? 'selected' : '' }} value="1">Active</option>
                        <option {{ $product->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
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

  <script>
    $(document).ready(function() {
      $('body').on('change', '.main-category', function() {

        $('.child-category').html('<option value="">Select</option>');
        let id = $(this).val();

        $.ajax({
          url: "{{ route('vendor.product.get-subcategories') }}",
          method: 'GET',
          data: {
            id: id,
          },
          success: function(data) {
            $('.sub-category').html('<option value="">Select</option>');

            $.each(data, function(i, item) {
              $('.sub-category').append(`<option class="${item.status == 0 ? 'field-disabled' : ''}" value="${item.id}">${ item.status == 1 ? item.name : item.name + ' (disabled)'}</option>`);
            })
          },
          error: function(xhr, status, err) {
            console.log(err);
          }
        })
      })

      $('body').on('change', '.sub-category', function() {
        let id = $(this).val();

        $.ajax({
          url: "{{ route('vendor.product.get-childcategories') }}",
          method: 'GET',
          data: {
            id: id,
          },
          success: function(data) {
            $('.child-category').html('<option value="">Select</option>');

            $.each(data, function(i, item) {

              $('.child-category').append(`<option class="${item.status == 0 ? 'field-disabled' : ''}" value="${item.id}">${ item.status == 1 ? item.name : item.name + ' (disabled)'}</option>`);

            })
          },
          error: function(xhr, status, err) {
            console.log(err);
          }
        })
      })
    })
  </script>

@endpush
