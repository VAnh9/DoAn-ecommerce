@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Slider</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Slider</h4>
                    <div class="card-header-action">
                      <a href="{{ route('admin.slider.index') }}" class="btn btn-primary">Back</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Preview</label> <br>
                        <img src="{{ asset($slider->banner) }}" width="200px" alt="image preview">
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="banner">Banner</label>
                        <input type="file" id="banner" name="banner" class="form-control">
                        @if ($errors->has('banner'))
                          <code>{{ $errors->first('banner') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="type">Type</label>
                        <input type="text" id="type" name="type" class="form-control" value="{{ $slider->type }}">
                        @if ($errors->has('type'))
                          <code>{{ $errors->first('type') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $slider->title }}">
                        @if ($errors->has('title'))
                          <code>{{ $errors->first('title') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="starting_price">Starting Price</label>
                        <input type="text" name="starting_price" class="form-control" value="{{ $slider->starting_price}}">
                        @if ($errors->has('starting_price'))
                          <code>{{ $errors->first('starting_price') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="btn_url">Button Url</label>
                        <input type="text" name="btn_url" class="form-control" value="{{ $slider->url }}">
                        @if ($errors->has('btn_url'))
                          <code>{{ $errors->first('btn_url') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="serial">Serial</label>
                        <input type="text" name="serial" class="form-control" value="{{ $slider->serial }}">
                        @if ($errors->has('serial'))
                          <code>{{ $errors->first('serial') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Status</label>
                         <select name="status" id="inputState" class="form-control">
                            <option {{ $slider->status == 1 ? 'selected' : '' }} value="1">Active</option>
                            <option {{ $slider->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
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

