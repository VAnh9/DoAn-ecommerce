@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Product Review Image Gallery</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>All Images</h4>
                    <div class="card-header-action">
                      <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                  </div>
                  <div class="card-body">
                    @foreach ($productReviewImages as $image )
                      <img src="{{ asset($image->image) }}" alt="image" style="height: auto; width: 200px" class="me-2">
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

@endsection


