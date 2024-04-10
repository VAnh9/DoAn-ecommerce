@php
  $productSliderTwo = json_decode($productSliderTwo->value);
@endphp
<div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
  <div class="card border">
    <div class="card-body">
      <form action="{{ route('admin.product-slider-section-two') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Category</label>
              <select name="category_two" class="form-control main-category">
                <option value="">Select</option>
                @foreach ($categories as $category )
                  <option {{ $category->id == $productSliderTwo->category ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('category_two'))
                <code>{{ $errors->first('category_two') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Sub Category</label>
              @php
                $subCategories = \App\Models\SubCategory::where('category_id', $productSliderTwo->category)->get();
              @endphp
              <select name="sub_category_two" class="form-control sub-category">
                <option value="">Select</option>
                @foreach ($subCategories as $subCategory )
                  <option {{ $subCategory->id == $productSliderTwo->sub_category ? 'selected' : '' }} value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('sub_category_two'))
                <code>{{ $errors->first('sub_category_two') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Child Category</label>
              @php
                $childCategories = \App\Models\ChildCategory::where('sub_category_id', $productSliderTwo->sub_category)->get();
              @endphp
              <select name="child_category_two" class="form-control child-category">
                <option value="">Select</option>
                @foreach ($childCategories as $childCategory )
                  <option {{ $childCategory->id == $productSliderTwo->child_category ? 'selected' : '' }} value="{{ $childCategory->id }}">{{ $childCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('child_category_two'))
                <code>{{ $errors->first('child_category_two') }}</code>
              @endif
            </div>
          </div>
        </div>


        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>

@push('scripts')
  <script>
    $(document).ready(function() {
      $('body').on('change', '.main-category', function(event) {
        let id = $(this).val();
        let row = $(this).closest('.row');
        $.ajax({
          url: "{{ route('admin.get-subcategories') }}",
          method: 'GET',
          data: {
            id: id
          },
          success: function(data) {
            let selector = row.find('.sub-category');
            let selector2 = row.find('.child-category');
            selector.html('<option value="">Select</option>');
            selector2.html('<option value="">Select</option>');
            $.each(data, function(i, item) {
              selector.append(`<option value="${item.id}">${item.name}</option>`);
            })
          },
          error: function(xhr, status, err) {
            console.log(err);
          }
        })
      })

      // get child categories
      $('body').on('change', '.sub-category', function() {
        let id = $(this).val();
        let row = $(this).closest('.row');
        $.ajax({
          method: 'GET',
          url: '{{ route('admin.product.get-childcategories') }}',
          data: {
            id: id,
          },
          success: function(data) {
            let selector = row.find('.child-category');
            selector.html('<option value="">Select</option>')

            $.each(data, function(i, item) {
              selector.append(`<option value="${item.id}">${item.name}</option>`)
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
