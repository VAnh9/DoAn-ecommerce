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
              <h4>Footer Grid Three Title</h4>
            </div>
            <div class="card-body">
              <form action="{{ route('admin.footer-grid-three.change-title') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-4">
                  <div class="form-group d-flex">
                    <input type="text" name="title" class="form-control" value="{{ @$footerTitle->footer_grid_three_title }}">
                    <button type="submit" class="btn btn-primary ml-3">Save</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Footer Grid Three</h4>
              <div class="card-header-action">
                <a href="{{ route('admin.footer-grid-three.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create New</a>
              </div>
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
          url: "{{ route('admin.footer-grid-three.change-status') }}",
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

