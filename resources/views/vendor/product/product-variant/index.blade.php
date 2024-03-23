@extends('vendor.layouts.master')

@section('content')


  <section id="wsus__dashboard">
    <div class="container-fluid">
        @include('vendor.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <h4>Product Variant</h4>
            <div class="text-end mb-2">
              <a href="{{ route('vendor.products.index') }}" class="btn btn-secondary rounded-pill">Back</a>
            </div>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                <div class="d-flex justify-content-between mb-4">
                  <h4>Product: {{ $product->name }}</h4>
                  <div>
                    <a href="{{ route('vendor.product-variant.create', ['product' => $product->id]) }}" class="btn btn-primary rounded-pill"><i class="fas fa-plus"></i> Create New</a>
                  </div>
                </div>
                {{ $dataTable->table([], true) }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



@endsection

@push('scripts')
  {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

  <script>
    $(document).ready(function() {
      $('body').on('click', '.change-status', function() {
        let isChecked = $(this).is(':checked');
        let id = $(this).data('id');
        $.ajax({
          url: "{{ route('vendor.product-variant.change-status') }}",
          method: 'PUT',
          data: {
            id: id,
            status: isChecked,
          },
          success: function(data) {
            toastr.success(data.message)
          },
          error: function(xhr, status, err) {
            console.log(err);
          }
        })
      })
    })
  </script>
@endpush

