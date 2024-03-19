@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Brand</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Brand</h4>
                    <div class="card-header-action">
                      <a href="{{ route('admin.brand.index') }}" class="btn btn-primary">Back</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                        <label for="">Preview</label> <br>
                        <img width="200px" src="{{ asset($brand->logo) }}" alt="">
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="logo">Logo</label>
                        <input type="file" id="logo" name="logo" class="form-control">
                        @if ($errors->has('logo'))
                          <code>{{ $errors->first('logo') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $brand->name }}">
                        @if ($errors->has('name'))
                          <code>{{ $errors->first('name') }}</code>
                        @endif
                      </div>


                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Is Featured</label>
                         <select name="is_featured" id="inputState" class="form-control">
                            <option value="">Select</option>
                            <option {{ $brand->is_featured == 1 ? 'selected' : '' }} value="1">Yes</option>
                            <option {{ $brand->is_featured == 0 ? 'selected' : '' }} value="0">No</option>
                         </select>
                         @if ($errors->has('is_featured'))
                          <code>{{ $errors->first('is_featured') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Status</label>
                         <select name="status" id="inputState" class="form-control">
                            <option {{ $brand->status == 1 ? 'selected' : '' }} value="1">Active</option>
                            <option {{ $brand->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
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

