@extends('vendor.layouts.master')

@section('title')
  {{ $settings->site_name }} || Withdraw
@endsection


@section('content')


  <section id="wsus__dashboard">
    <div class="container-fluid">
        @include('vendor.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <h4 class="mb-2"><i class="far fa-wallet"></i> Withdraw</h4>
            <div class="wsus__dashboard">
              <div class="row">
                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item sky" href="javascript:;">
                    <i class="fas fa-wallet"></i>
                    <p>Current Balance</p>
                    <h5 class="text-white">{{ $settings->currency_icon }}{{ $currentBalance }}</h5>
                  </a>
                </div>

                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item sky" href="javascript:;">
                    <i class="fas fa-wallet"></i>
                    <p>Pending Amount</p>
                    <h5 class="text-white">{{ $settings->currency_icon }}{{ $pendingAmount }}</h5>
                  </a>
                </div>

                <div class="col-xl-2 col-6 col-md-4">
                  <a class="wsus__dashboard_item sky" href="javascript:;">
                    <i class="fas fa-wallet"></i>
                    <p>Total Withdraw</p>
                    <h5 class="text-white">{{ $settings->currency_icon }}{{ $totalWithdraw }}</h5>
                  </a>
                </div>
              </div>
            </div>
            <div class="text-end mb-2">
              <a href="{{ route('vendor.withdraw.create') }}" class="btn btn-primary rounded-pill"><i class="fas fa-plus"></i> Create Request</a>
            </div>
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

@endpush

