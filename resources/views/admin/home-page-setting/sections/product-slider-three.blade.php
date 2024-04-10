@php
  $productSliderThree = json_decode($productSliderThree->value);
@endphp
<div class="tab-pane fade" id="list-slider-three" role="tabpanel" aria-labelledby="list-slider-three-list">
  <div class="card border">
    <div class="card-body">
      <form action="{{ route('admin.product-slider-section-three') }}" method="POST">
        @csrf
        @method('PUT')

        <h5>Part 1</h5>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Category</label>
              <select name="cate_one" class="form-control main-category">
                <option value="">Select</option>
                @foreach ($categories as $category )
                  <option {{ $category->id == $productSliderThree[0]->category ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('cate_one'))
                <code>{{ $errors->first('cate_one') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Sub Category</label>
              @php
                $subCategories = \App\Models\SubCategory::where('category_id', $productSliderThree[0]->category)->get();
              @endphp
              <select name="sub_cate_one" class="form-control sub-category">
                <option value="">Select</option>
                @foreach ($subCategories as $subCategory )
                  <option {{ $subCategory->id == $productSliderThree[0]->sub_category ? 'selected' : '' }} value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('sub_cate_one'))
                <code>{{ $errors->first('sub_cate_one') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Child Category</label>
              @php
                $childCategories = \App\Models\ChildCategory::where('sub_category_id', $productSliderThree[0]->sub_category)->get();
              @endphp
              <select name="child_cate_one" class="form-control child-category">
                <option value="">Select</option>
                @foreach ($childCategories as $childCategory )
                  <option {{ $childCategory->id == $productSliderThree[0]->child_category ? 'selected' : '' }} value="{{ $childCategory->id }}">{{ $childCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('child_cate_one'))
                <code>{{ $errors->first('child_cate_one') }}</code>
              @endif
            </div>
          </div>
        </div>

        {{-- slider 2 --}}
        <h5>Part 2</h5>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Category</label>
              <select name="cate_two" class="form-control main-category">
                <option value="">Select</option>
                @foreach ($categories as $category )
                  <option {{ $category->id == $productSliderThree[1]->category ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('cate_two'))
                <code>{{ $errors->first('cate_two') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Sub Category</label>
              @php
                $subCategories = \App\Models\SubCategory::where('category_id', $productSliderThree[1]->category)->get();
              @endphp
              <select name="sub_cate_two" class="form-control sub-category">
                <option value="">Select</option>
                @foreach ($subCategories as $subCategory )
                  <option {{ $subCategory->id == $productSliderThree[1]->sub_category ? 'selected' : '' }} value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('sub_cate_two'))
                <code>{{ $errors->first('sub_cate_two') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Child Category</label>
              @php
                $childCategories = \App\Models\ChildCategory::where('sub_category_id', $productSliderThree[1]->sub_category)->get();
              @endphp
              <select name="child_cate_two" class="form-control child-category">
                <option value="">Select</option>
                @foreach ($childCategories as $childCategory )
                  <option {{ $childCategory->id == $productSliderThree[1]->child_category ? 'selected' : '' }} value="{{ $childCategory->id }}">{{ $childCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('child_cate_two'))
                <code>{{ $errors->first('child_cate_two') }}</code>
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
