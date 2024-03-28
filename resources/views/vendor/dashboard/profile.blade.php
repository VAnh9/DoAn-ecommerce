@extends('vendor.layouts.master')

@section('title')
  {{ $settings->site_name }} || Profile
@endsection

@section('content')

  <!--=============================
    DASHBOARD START
  ==============================-->
  <section id="wsus__dashboard">
    <div class="container-fluid">
        @include('vendor.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <h3><i class="far fa-user"></i> profile</h3>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                <h4>basic information</h4>

                    <form action="{{ route('vendor.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <div class="wsus__dash_pro_img">
                                      <img src="{{Auth::user()->image ? asset(Auth::user()->image) : asset('frontend/images/ts-2.jpg')}}" alt="img" class="img-fluid w-100">
                                      <input type="file" name="image" class="form-control">
                                    </div>
                                </div>
                                @if ($errors->has('image'))
                                        <code class="">{{ $errors->first('image') }}</code>
                                @endif
                            </div>
                          <div class="row mt-4">
                            <div class="col-xl-6 col-md-6">
                                <div class="wsus__dash_pro_single">
                                    <i class="fas fa-user-tie"></i>
                                    <input type="text" placeholder="Name" class="form-control" name="name" value="{{ Auth::user()->name }}">
                                </div>

                                @if ($errors->has('name'))
                                    <code class="offset-1 offset-md-2 offset-xl-1">{{ $errors->first('name') }}</code>
                                @endif
                            </div>

                            <div class="col-xl-6 col-md-6">
                                <div class="wsus__dash_pro_single">
                                  <i class="fal fa-envelope-open"></i>
                                  <input type="email" class="form-control" placeholder="Email" name="email" value="{{ Auth::user()->email }}">
                                </div>
                                @if ($errors->has('email'))
                                    <code class="offset-1 offset-md-2 offset-xl-1">{{ $errors->first('email') }}</code>
                                @endif
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="wsus__dash_pro_single">
                                  <i class="fas fa-user-tie"></i>
                                  <input type="text" placeholder="User name" class="form-control" name="username" value="{{ Auth::user()->username }}">
                                </div>
                                @if ($errors->has('username'))
                                    <code class="offset-1 offset-md-2 offset-xl-1">{{ $errors->first('username') }}</code>
                                @endif
                            </div>

                            <div class="col-xl-6 col-md-6">
                              <div class="wsus__dash_pro_single">
                                <i class="far fa-phone-alt"></i>
                                <input type="text" placeholder="Phone" class="form-control" name="phone" value="{{ Auth::user()->phone }}">
                              </div>
                              @if ($errors->has('phone'))
                                    <code class="offset-1 offset-md-2 offset-xl-1">{{ $errors->first('phone') }}</code>
                                @endif
                            </div>
                          </div>
                        </div>

                        <div class="col-xl-12">
                          <button class="common_btn mb-4 mt-3" type="submit">upload</button>
                        </div>
                    </form>



                        <div class="wsus__dash_pass_change mt-2">
                            <form action="{{ route('vendor.profile.update.password') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <h4>Update Password</h4>

                                    <div class="col-xl-4 col-md-6">
                                      <div class="wsus__dash_pro_single mt-1">
                                        <i class="fas fa-unlock-alt"></i>
                                        <input type="password" name="current_password" placeholder="Current Password" class="form-control">
                                      </div>
                                        @if ($errors->has('current_password'))
                                            <code style="margin-left: 56px">{{ $errors->first('current_password') }}</code>
                                        @endif
                                    </div>

                                    <div class="col-xl-4 col-md-6">
                                      <div class="wsus__dash_pro_single mt-1">
                                        <i class="fas fa-lock-alt"></i>
                                        <input type="password" name="password" placeholder="New Password" class="form-control">
                                      </div>
                                        @if ($errors->has('password'))
                                            <code style="margin-left: 56px">{{ $errors->first('password') }}</code>
                                        @endif
                                    </div>

                                    <div class="col-xl-4">
                                      <div class="wsus__dash_pro_single mt-1">
                                        <i class="fas fa-lock-alt"></i>
                                        <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control">
                                      </div>
                                    </div>


                                    <div class="col-xl-12">
                                      <button class="common_btn mt-3" type="submit">upload</button>
                                    </div>
                                  </div>
                            </form>
                        </div>



              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--=============================
    DASHBOARD END
  ==============================-->


@endsection
