@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Product Variant Item</h1>
          </div>

          <div class="card-header-action d-flex justify-content-end">
            <a href="{{ route('admin.product-variant.index', ['product' => $product->id]) }}" class="btn btn-secondary mb-3">Back</a>
          </div>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Variant: {{ $variant->name }} </h4>
                    <div class="card-header-action">
                      <a href="{{ route('admin.product-variant-item.create', $variant->id) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create New</a>
                    </div>
                  </div>
                  <div class="card-body">
                    {{ $dataTable->table(['id'=> 'product_variant_item'], true) }}
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
          url: "{{ route('admin.product-variant-item.change-status') }}",
          method: 'PUT',
          data: {
            id: id,
            status: isChecked
          },
          success: function(data) {
            toastr.success(data.message);
          },
          error: function(xhr, status, err) {
            console.log(err);
          }
        })
      })
    })
  </script>
@endpush

{{-- @push('script_reload_datatb')
  <script>
    let dataTable = $('#product_variant_item');
    dataTable.draw();

  </script>
@endpush --}}

