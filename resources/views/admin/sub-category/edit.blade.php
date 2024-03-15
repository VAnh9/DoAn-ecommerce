@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Sub Category</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Sub Category</h4>
                    <div class="card-header-action">
                      <a href="{{ route('admin.sub-category.index') }}" class="btn btn-primary">Back</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.sub-category.update', $subCategory->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Name</label>
                        <input type="text"  name="name" class="form-control" value="{{ $subCategory->name }}">
                        @if ($errors->has('name'))
                          <code>{{ $errors->first('name') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Category</label> <br>
                         <select name="category" id="inputState" class="form-control">
                            <option value="">Select</option>
                            @foreach ($categories as $category )
                              <option {{ $category->id == $subCategory->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                         </select>
                         @if ($errors->has('category'))
                          <code>{{ $errors->first('category') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Status</label>
                         <select name="status" id="inputState" class="form-control">
                            <option {{ $subCategory->status == 1 ? 'selected' : '' }} value="1">Active</option>
                            <option {{ $subCategory->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
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

