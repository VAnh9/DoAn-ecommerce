@extends('frontend.dashboard.layouts.master')

@section('title')
  {{ $settings->site_name }} || Request to Vendor
@endsection


@section('content')


  <section id="wsus__dashboard">
    <div class="container-fluid">
        @include('frontend.dashboard.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <h4 class="mb-2"><i class="far fa-store"></i> Become A Vendor Today</h4>
            <div class="wsus__dashboard_profile mb-3">
              <div class="wsus__dash_pro_area">
                {!! @$content->content !!}
              </div>
            </div>

            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                <form action="{{ route('user.vendor-request.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <div class="wsus__dash_pro_single">
                      <i class="fas fa-image fa-lg"></i>
                      <input type="file" name="banner">
                    </div>
                    @if ($errors->has('banner'))
                      <code class="">{{ $errors->first('banner') }}</code>
                    @endif
                  </div>

                  <div class="form-group">
                    <div class="wsus__dash_pro_single">
                      <i class="fas fa-store-alt"></i>
                      <input type="text" name="name" placeholder="Shop Name">
                    </div>
                    @if ($errors->has('name'))
                      <code class="">{{ $errors->first('name') }}</code>
                    @endif
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="wsus__dash_pro_single">
                        <i class="fal fa-envelope-open"></i>
                        <input type="email" name="email" placeholder="Shop Email">
                      </div>
                      @if ($errors->has('email'))
                        <code class="">{{ $errors->first('email') }}</code>
                      @endif
                    </div>

                    <div class="col-md-6">
                      <div class="wsus__dash_pro_single">
                        <i class="far fa-phone-alt"></i>
                        <input type="text" name="phone" placeholder="Shop Phone">
                      </div>
                      @if ($errors->has('phone'))
                        <code class="">{{ $errors->first('phone') }}</code>
                      @endif
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="wsus__dash_pro_single">
                      <i class="far fa-map-marker-alt fa-lg"></i>
                      <input type="text" name="address" placeholder="Shop Address">
                    </div>
                    @if ($errors->has('address'))
                      <code class="">{{ $errors->first('address') }}</code>
                    @endif
                  </div>

                  <div class="form-group">
                    <div class="wsus__dash_pro_single">
                      <textarea name="description" id="" placeholder="About You"></textarea>
                    </div>
                    @if ($errors->has('description'))
                      <code class="">{{ $errors->first('description') }}</code>
                    @endif
                  </div>

                  <button type="submit" class="btn btn-primary mt-4">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



@endsection


