@extends('admin.layouts.master')

@section('content')

<!-- Main Content -->
<section class="section">
  <div class="section-header">
    <h1>Footer</h1>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Footer Info</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.footer-info.update', 1) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')


              <div class="form-group">
                <img src="{{ asset(@$footerInfo->logo) }}" width="200px" alt="">
                <br>
                <label>Footer Logo</label>
                <input type="file" class="form-control" name="logo">
                @if ($errors->has('logo'))
                  <code>{{ $errors->first('logo') }}</code>
                @endif
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" class="form-control" name="phone" value="{{ @$footerInfo->phone }}">
                    @if ($errors->has('phone'))
                      <code>{{ $errors->first('phone') }}</code>
                    @endif
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ @$footerInfo->email }}">
                    @if ($errors->has('email'))
                      <code>{{ $errors->first('email') }}</code>
                    @endif
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="">Address</label>
                <input type="text" class="form-control" name="address" value="{{ @$footerInfo->address }}">
                @if ($errors->has('address'))
                  <code>{{ $errors->first('address') }}</code>
                @endif
              </div>

              <div class="form-group">
                <label for="">Copyright</label>
                <input type="text" class="form-control" name="copyright" value="{{ @$footerInfo->copyright }}">
                @if ($errors->has('copyright'))
                  <code>{{ $errors->first('copyright') }}</code>
                @endif
              </div>

              <button type="submit" class="btn btn-primary">Save</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
