@extends('vendor.layouts.master')

@section('title')
  {{ $settings->site_name }} || Withdraw Request
@endsection

@section('content')


  <section id="wsus__dashboard">
    <div class="container-fluid">
        @include('vendor.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <h3><i class="far fa-wallet"></i> Withdraw Request</h3>
            <div class="text-end mb-2">
              <a href="{{ route('vendor.withdraw.index') }}" class="btn btn-secondary rounded-pill">Back</a>
            </div>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <th style="width: 300px">Withdraw Method</th>
                      <td>{{ $withdrawRequest->method }}</td>
                    </tr>
                    <tr>
                      <th style="width: 300px">Withdraw Charge</th>
                      <td>{{ ($withdrawRequest->withdraw_charge / $withdrawRequest->total_amount) * 100 }}%</td>
                    </tr>
                    <tr>
                      <th style="width: 300px">Withdraw Charge Amount</th>
                      <td>{{ $settings->currency_icon }}{{ $withdrawRequest->withdraw_charge }}</td>
                    </tr>
                    <tr>
                      <th style="width: 300px">Total Amount</th>
                      <td>{{ $settings->currency_icon }}{{ $withdrawRequest->total_amount }}</td>
                    </tr>
                    <tr>
                      <th style="width: 300px">Withdraw Amount</th>
                      <td>{{ $settings->currency_icon }}{{ $withdrawRequest->withdraw_amount }}</td>
                    </tr>
                    <tr>
                      <th style="width: 300px">Status</th>
                      <td>
                        @if ($withdrawRequest->status == 'pending')
                          <i class="badge bg-warning">Pending</i>
                        @elseif ($withdrawRequest->status == 'paid')
                          <i class="badge bg-success">Paid</i>
                        @else
                          <i class="badge bg-secondary">Declined</i>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <th style="width: 300px">Account Information</th>
                      <td>{{ $withdrawRequest->account_info }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



@endsection

