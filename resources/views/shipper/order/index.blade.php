@extends('shipper.layouts.master')

@section('title')
  {{ $settings->site_name }} || Order
@endsection


@section('content')


  <section id="wsus__dashboard">
    <div class="container-fluid">
        @include('shipper.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <h4 class="mb-2"><i class="far fa-truck"></i> Orders</h4>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
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
    $('body').on('change', '.change-order-status-shipper', function() {
      let orderId = $(this).data('id');
      let orderStatus = $(this).val();

      $.ajax({
        method: 'PUT',
        url: "{{ route('shipper.order.update.status') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
          orderId: orderId,
          orderStatus: orderStatus
        },
        success: function(response) {
          if(response.status == 'success') {
            toastr.success(response.message);
            window.LaravelDataTables["shipperorder-table"].ajax.reload();
          }
        },
        error: function(xhr, status, err) {
          console.log(err);
        }
      })
    })
  })
</script>
@endpush

