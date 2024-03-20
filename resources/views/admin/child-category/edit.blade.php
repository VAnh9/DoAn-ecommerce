@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Child Category</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Child Category</h4>
                    <div class="card-header-action">
                      <a href="{{ route('admin.child-category.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.child-category.update', $childCategory->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Name</label>
                        <input type="text"  name="name" class="form-control" value="{{ $childCategory->name }}">
                        @if ($errors->has('name'))
                          <code>{{ $errors->first('name') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Category</label> <br>
                         <select name="category" id="inputState" class="form-control main-category">
                            <option value="">Select</option>
                            @foreach ($categories as $category )
                              <option {{ $category->id == $childCategory->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                         </select>
                         @if ($errors->has('category'))
                          <code>{{ $errors->first('category') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Sub Category</label> <br>
                         <select name="sub_category" id="inputState" class="form-control sub-category">
                            <option value="">Select</option>
                            @foreach ($subCategories as $subCategory )
                              <option {{ $subCategory->id == $childCategory->sub_category_id ? 'selected' : '' }} value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                            @endforeach
                         </select>
                         @if ($errors->has('sub_category'))
                          <code>{{ $errors->first('sub_category') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Status</label>
                         <select name="status" id="inputState" class="form-control">
                            <option {{ $childCategory->status == 1 ? 'selected' : '' }} value="1">Active</option>
                            <option {{ $childCategory->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
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
      $('body').on('change', '.main-category', function(event) {
        let id = $(this).val();
        $.ajax({
          url: "{{ route('admin.get-subcategories') }}",
          method: 'GET',
          data: {
            id: id
          },
          success: function(data) {
            $('.sub-category').html('<option value="">Select</option>');
            $.each(data, function(i, item) {
              $('.sub-category').append(`<option value="${item.id}">${item.name}</option>`);
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

