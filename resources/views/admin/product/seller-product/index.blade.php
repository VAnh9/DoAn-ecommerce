@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Sellers Product</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>All Seller's Products</h4>
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

  <script>
    $(document).ready(function() {
      $('body').on('click', '.change-status', function() {
        let isChecked = $(this).is(':checked');
        let id = $(this).data('id');
        $.ajax({
          url: "{{ route('admin.product.change-status') }}",
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

      /* change approve status */

      $('body').on('change', '.is_approved', function() {
        let id = $(this).data('id');
        let approveStatus = $(this).val();
        $.ajax({
          url: "{{ route('admin.change-approve-status') }}",
          method: 'PUT',
          data: {
            id: id,
            value: approveStatus
          },
          success: function(data) {
            toastr.success(data.message);
            window.LaravelDataTables["sellerproducts-table"].ajax.reload();
          },
          error: function(xhr, status, err) {
            console.log(err);
          }
        })
      })
    })
  </script>
@endpush

