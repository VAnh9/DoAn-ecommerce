@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Product</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Create Product</h4>
                    <div class="card-header-action">
                      <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Thumb Image <span class="field-required">*</span></label>
                        <input type="file" id="" name="image" class="form-control">
                        @if ($errors->has('image'))
                          <code>{{ $errors->first('image') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Name <span class="field-required">*</span></label>
                        <input type="text" id="" name="name" class="form-control" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                          <code>{{ $errors->first('name') }}</code>
                        @endif
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label for="inputState">Category <span class="field-required">*</span></label>
                             <select name="category" id="inputState" class="form-control main-category">
                                <option value="">Select</option>
                                @foreach ($categories as $category )
                                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                             </select>
                             @if ($errors->has('category'))
                              <code>{{ $errors->first('category') }}</code>
                            @endif
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label for="inputState">Sub Category</label>
                             <select name="sub_category" id="inputState" class="form-control sub-category">
                                <option value="">Select</option>
                             </select>
                             @if ($errors->has('sub_category'))
                              <code>{{ $errors->first('sub_category') }}</code>
                            @endif
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label for="inputState">Child Category</label>
                             <select name="child_category" id="inputState" class="form-control child-category">
                                <option value="">Select</option>
                             </select>
                             @if ($errors->has('child_category'))
                              <code>{{ $errors->first('child_category') }}</code>
                            @endif
                          </div>
                        </div>
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Brand <span class="field-required">*</span></label>
                         <select name="brand" id="inputState" class="form-control">
                            <option value="">Select</option>
                            @foreach ($brands as $brand )
                              <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                         </select>
                         @if ($errors->has('brand'))
                          <code>{{ $errors->first('brand') }}</code>
                        @endif
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label for="">SKU</label>
                            <input type="text" id="" name="sku" class="form-control" value="{{ old('sku') }}">
                            @if ($errors->has('sku'))
                              <code>{{ $errors->first('sku') }}</code>
                            @endif
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label for="">Price ({{ $settings->currency_icon }})<span class="field-required">*</span></label>
                            <input type="text" name="price" class="form-control" value="{{ old('price') }}">
                            @if ($errors->has('price'))
                              <code>{{ $errors->first('price') }}</code>
                            @endif
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label for="">Stock Quantity <span class="field-required">*</span></label>
                            <input type="number" min="0" name="qty" class="form-control" value="{{ old('qty') }}">
                            @if ($errors->has('qty'))
                              <code>{{ $errors->first('qty') }}</code>
                            @endif
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label for="">Offer Price ({{ $settings->currency_icon }}) </label>
                            <input type="text" name="offer_price" class="form-control" value="{{ old('offer_price') }}">
                            @if ($errors->has('offer_price'))
                              <code>{{ $errors->first('offer_price') }}</code>
                            @endif
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label for="">Offer Start Date</label>
                            <input type="text" name="offer_start_date" class="form-control datepicker" value="{{ old('offer_start_date') }}">
                            @if ($errors->has('offer_start_date'))
                              <code>{{ $errors->first('offer_start_date') }}</code>
                            @endif
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label for="">Offer End Date</label>
                            <input type="text" name="offer_end_date" class="form-control datepicker" value="{{ old('offer_end_date') }}">
                            @if ($errors->has('offer_end_date'))
                              <code>{{ $errors->first('offer_end_date') }}</code>
                            @endif
                          </div>
                        </div>
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Short Description <span class="field-required">*</span></label>
                        <textarea name="short_description" class="form-control"></textarea>
                        @if ($errors->has('short_description'))
                          <code>{{ $errors->first('short_description') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Long Description <span class="field-required">*</span></label>
                        <textarea name="long_description" class="form-control summernote-simple"></textarea>
                        @if ($errors->has('long_description'))
                          <code>{{ $errors->first('long_description') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Video Link</label>
                        <input type="text" name="video_link" class="form-control" value="{{ old('video_link') }}">
                        @if ($errors->has('video_link'))
                          <code>{{ $errors->first('video_link') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Product Type</label>
                          <select name="product_type" id="inputState" class="form-control">
                            <option value="">Select</option>
                            <option value="new_arrival">New Arrival</option>
                            <option value="featured_product">Featured</option>
                            <option value="top_product">Top Product</option>
                            <option value="best_product">Best Product</option>
                          </select>
                          @if ($errors->has('is_top'))
                          <code>{{ $errors->first('is_top') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Seo Title</label>
                        <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title') }}">
                        @if ($errors->has('seo_title'))
                          <code>{{ $errors->first('seo_title') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Seo Description</label>
                        <textarea name="seo_description" class="form-control"></textarea>
                        @if ($errors->has('seo_description'))
                          <code>{{ $errors->first('seo_description') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
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
        </section>


@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
      $('body').on('change', '.main-category', function() {
        $('.child-category').html('<option value="">Select</option>')
        let id = $(this).val();
        $.ajax({
          method: 'GET',
          url: '{{ route('admin.product.get-subcategories') }}',
          data: {
            id: id,
          },
          success: function(data) {
            $('.sub-category').html('<option value="">Select</option>')

            $.each(data, function(i, item) {
              $('.sub-category').append(`<option value="${item.id}">${item.name}</option>`)
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
          method: 'GET',
          url: '{{ route('admin.product.get-childcategories') }}',
          data: {
            id: id,
          },
          success: function(data) {
            $('.child-category').html('<option value="">Select</option>')

            $.each(data, function(i, item) {
              $('.child-category').append(`<option value="${item.id}">${item.name}</option>`)
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

<style>
  .note-editor.note-frame.card {
    margin-bottom: 0;
  }
</style>
