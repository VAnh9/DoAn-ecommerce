@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Profile</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Profile</div>
      </div>
    </div>
    <div class="section-body">
      <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-10">
          <div class="card">
            <form method="post" action="{{ route('admin.profile.update') }}" class="needs-validation" novalidate="" enctype="multipart/form-data">
            @csrf
              <div class="card-header">
                <h4>Update Profile</h4>
              </div>
              <div class="card-body">
                  <div class="row">

                    <div class="form-group col-12">
                        <div class="mb-3">
                            <img width="100px" src="{{ asset(Auth::user()->image) }}" alt="">
                        </div>
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                        @if ($errors->has('image'))
                            <code>{{ $errors->first('image') }}</code>
                        @endif
                    </div>

                    <div class="form-group col-md-6 col-12">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required="">
                        @if ($errors->has('name'))
                            <code>{{ $errors->first('name') }}</code>
                        @endif
                    </div>

                    <div class="form-group col-md-6 col-12">
                      <label>Email</label>
                      <input type="text" name="email" class="form-control" value="{{ Auth::user()->email }}" required="">
                        @if ($errors->has('email'))
                            <code>{{ $errors->first('email') }}</code>
                        @endif
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone }}">
                        @if ($errors->has('phone'))
                            <code>{{ $errors->first('phone') }}</code>
                        @endif
                      </div>

                      <div class="form-group col-md-6 col-12">
                        <label>User Name</label>
                        <input type="text" name="username" class="form-control" value="{{ Auth::user()->username }}" >
                        @if ($errors->has('username'))
                            <code>{{ $errors->first('username') }}</code>
                        @endif
                      </div>
                  </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary">Save Changes</button>
              </div>
            </form>
          </div>
        </div>

        <div class="col-12 col-md-12 col-lg-10">
            <div class="card">
              <form method="post" action="{{ route('admin.password.update') }}" class="needs-validation" novalidate="" enctype="multipart/form-data">
              @csrf
                <div class="card-header">
                  <h4>Update Password</h4>
                </div>
                <div class="card-body">
                    <div class="row">

                      <div class="form-group col-12">
                        <label>Current Password</label>
                        <input type="password" name="current_password" class="form-control" >
                        @if ($errors->has('current_password'))
                            <code>{{ $errors->first('current_password') }}</code>
                        @endif
                      </div>

                      <div class="form-group col-12">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control" >
                        @if ($errors->has('password'))
                            <code>{{ $errors->first('password') }}</code>
                        @endif
                      </div>

                      <div class="form-group col-12">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" >
                      </div>

                    </div>
                </div>
                <div class="card-footer text-right">
                  <button class="btn btn-primary">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
      </div>
    </div>
  </section>
@endsection
