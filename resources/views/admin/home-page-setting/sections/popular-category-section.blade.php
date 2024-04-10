@php
  $popularCategorySection = json_decode($popularCategorySection->value);
@endphp

<div class="tab-pane fade show active" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
  <div class="card border">
    <div class="card-body">
      <form action="{{ route('admin.popular-category-section') }}" method="POST">
        @csrf
        @method('PUT')

        <h5>Category 1</h5>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Category</label>
              <select name="cat_one" class="form-control main-category">
                <option value="">Select</option>
                @foreach ($categories as $category )
                  <option {{ $category->id == $popularCategorySection[0]->category ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('cat_one'))
                <code>{{ $errors->first('cat_one') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Sub Category</label>
              @php
                $subCategories = \App\Models\SubCategory::where('category_id', $popularCategorySection[0]->category)->get();
              @endphp
              <select name="sub_cat_one" class="form-control sub-category">
                <option value="">Select</option>
                @foreach ($subCategories as $subCategory )
                  <option {{ $subCategory->id == $popularCategorySection[0]->sub_category ? 'selected' : '' }} value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('sub_cat_one'))
                <code>{{ $errors->first('sub_cat_one') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Child Category</label>
              @php
                $childCategories = \App\Models\ChildCategory::where('sub_category_id', $popularCategorySection[0]->sub_category )->get();
              @endphp
              <select name="child_cat_one" class="form-control child-category">
                <option value="">Select</option>
                @foreach ($childCategories as $childCategory )
                  <option {{ $childCategory->id == $popularCategorySection[0]->child_category ? 'selected' : '' }} value="{{ $childCategory->id }}">{{ $childCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('child_cat_one'))
                <code>{{ $errors->first('child_cat_one') }}</code>
              @endif
            </div>
          </div>
        </div>

        {{-- Category 2 --}}

        <h5>Category 2</h5>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Category</label>
              <select name="cat_two" class="form-control main-category">
                <option value="">Select</option>
                @foreach ($categories as $category )
                  <option {{ $category->id == $popularCategorySection[1]->category ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('cat_two'))
                <code>{{ $errors->first('cat_two') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Sub Category</label>
              @php
                $subCategories = \App\Models\SubCategory::where('category_id', $popularCategorySection[1]->category)->get();
              @endphp
              <select name="sub_cat_two" class="form-control sub-category">
                <option value="">Select</option>
                @foreach ($subCategories as $subCategory )
                  <option {{ $subCategory->id == $popularCategorySection[1]->sub_category ? 'selected' : '' }} value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('sub_cat_two'))
                <code>{{ $errors->first('sub_cat_two') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Child Category</label>
              @php
                $childCategories = \App\Models\ChildCategory::where('sub_category_id', $popularCategorySection[1]->sub_category )->get();
              @endphp
              <select name="child_cat_two" class="form-control child-category">
                <option value="">Select</option>
                @foreach ($childCategories as $childCategory )
                  <option {{ $childCategory->id == $popularCategorySection[1]->child_category ? 'selected' : '' }} value="{{ $childCategory->id }}">{{ $childCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('child_cat_two'))
                <code>{{ $errors->first('child_cat_two') }}</code>
              @endif
            </div>
          </div>
        </div>


        {{-- Category 3 --}}
        <h5>Category 3</h5>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Category</label>
              <select name="cat_three" class="form-control main-category">
                <option value="">Select</option>
                @foreach ($categories as $category )
                  <option {{ $category->id == $popularCategorySection[2]->category ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('cat_three'))
                <code>{{ $errors->first('cat_three') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Sub Category</label>
              @php
                $subCategories = \App\Models\SubCategory::where('category_id', $popularCategorySection[2]->category)->get();
              @endphp
              <select name="sub_cat_three" class="form-control sub-category">
                <option value="">Select</option>
                @foreach ($subCategories as $subCategory )
                  <option {{ $subCategory->id == $popularCategorySection[2]->sub_category ? 'selected' : '' }} value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('sub_cat_three'))
                <code>{{ $errors->first('sub_cat_three') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Child Category</label>
              @php
                $childCategories = \App\Models\ChildCategory::where('sub_category_id', $popularCategorySection[2]->sub_category )->get();
              @endphp
              <select name="child_cat_three" class="form-control child-category">
                <option value="">Select</option>
                @foreach ($childCategories as $childCategory )
                  <option {{ $childCategory->id == $popularCategorySection[2]->child_category ? 'selected' : '' }} value="{{ $childCategory->id }}">{{ $childCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('child_cat_three'))
                <code>{{ $errors->first('child_cat_three') }}</code>
              @endif
            </div>
          </div>
        </div>


        {{-- Category 4 --}}
        <h5>Category 4</h5>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Category</label>
              <select name="cat_four" class="form-control main-category">
                <option value="">Select</option>
                @foreach ($categories as $category )
                  <option {{ $category->id == $popularCategorySection[3]->category ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('cat_four'))
                <code>{{ $errors->first('cat_four') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Sub Category</label>
              @php
                $subCategories = \App\Models\SubCategory::where('category_id', $popularCategorySection[3]->category)->get();
              @endphp
              <select name="sub_cat_four" class="form-control sub-category">
                <option value="">Select</option>
                @foreach ($subCategories as $subCategory )
                  <option {{ $subCategory->id == $popularCategorySection[3]->sub_category ? 'selected' : '' }} value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('sub_cat_four'))
                <code>{{ $errors->first('sub_cat_four') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Child Category</label>
              @php
                $childCategories = \App\Models\ChildCategory::where('sub_category_id', $popularCategorySection[3]->sub_category )->get();
              @endphp
              <select name="child_cat_four" class="form-control child-category">
                <option value="">Select</option>
                @foreach ($childCategories as $childCategory )
                  <option {{ $childCategory->id == $popularCategorySection[3]->child_category ? 'selected' : '' }} value="{{ $childCategory->id }}">{{ $childCategory->name }}</option>
                @endforeach
              </select>
              @if ($errors->has('child_cat_four'))
                <code>{{ $errors->first('child_cat_four') }}</code>
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

