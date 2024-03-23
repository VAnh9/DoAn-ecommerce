@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Product Image Gallery</h1>
          </div>

          <div class="card-header-action d-flex justify-content-end mb-3">
            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Back</a>
          </div>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Product: {{ $product->name }}</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.product-image-gallery.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Image <code>(Multiple image supported!)</code></label>
                        <input type="file" name="image[]" class="form-control" multiple>
                        <input type="hidden" name="product" value="{{ $product->id }}">
                        @if ($errors->has('image'))
                          <code>{{ $errors->first('image') }}</code>
                        @endif
                        @if ($errors->has('image.*'))
                          <code>{{ $errors->first('image.*') }}</code>
                        @endif
                      </div>
                      <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>All Images</h4>
                  </div>
                  <div class="card-body">
                    {{ $dataTable->table([], true) }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

@endsection

@push('scripts')
  {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

