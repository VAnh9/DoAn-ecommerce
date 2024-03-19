@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Vendor Profile</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Update Vendor Profile</h4>
                    <div class="card-header-action">
                      {{-- <a href="{{ route('admin.slider.index') }}" class="btn btn-primary">Back</a> --}}
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.vendor-profile.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Preview</label> <br>
                        <img width="200px" src="{{ asset($profile->banner) }}" alt="">
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="banner">Banner</label>
                        <input type="file" id="banner" name="banner" class="form-control">
                        @if ($errors->has('banner'))
                          <code>{{ $errors->first('banner') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="name">Name</label>
                        <input type="text" id="type" name="name" class="form-control" value="{{ $profile->name }}">
                        @if ($errors->has('name'))
                          <code>{{ $errors->first('name') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $profile->phone }}">
                        @if ($errors->has('phone'))
                          <code>{{ $errors->first('phone') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $profile->email }}">
                        @if ($errors->has('email'))
                          <code>{{ $errors->first('email') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ $profile->address }}">
                        @if ($errors->has('address'))
                          <code>{{ $errors->first('address') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Description</label>
                        <textarea name="description" id="" class="summernote-simple">{{ $profile->description }}</textarea>
                        @if ($errors->has('description'))
                          <code>{{ $errors->first('description') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Facebook</label>
                        <input type="text" name="fb_link" class="form-control" value="{{ $profile->fb_link }}">
                        @if ($errors->has('fb_link'))
                          <code>{{ $errors->first('fb_link') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Twitter</label>
                        <input type="text" name="tw_link" class="form-control" value="{{ $profile->tw_link }}">
                        @if ($errors->has('tw_link'))
                          <code>{{ $errors->first('tw_link') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Instagram</label>
                        <input type="text" name="insta_link" class="form-control" value="{{ $profile->insta_link }}">
                        @if ($errors->has('insta_link'))
                          <code>{{ $errors->first('insta_link') }}</code>
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

