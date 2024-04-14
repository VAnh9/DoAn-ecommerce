@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Product Review</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>All Reviews</h4>
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
          url: "{{ route('admin.review.change-status') }}",
          method: 'PUT',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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

