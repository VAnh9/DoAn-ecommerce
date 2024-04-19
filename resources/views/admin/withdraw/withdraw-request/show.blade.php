@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Withdraw Request</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Request Detail Information</h4>
                    <div class="card-header-action">
                      <a href="{{ route('admin.withdraw-list.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                  </div>
                  <div class="card-body">
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
                              <i class="badge badge-warning">Pending</i>
                            @elseif ($withdrawRequest->status == 'paid')
                              <i class="badge badge-success">Paid</i>
                            @else
                              <i class="badge badge-secondary">Declined</i>
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th style="width: 300px">Account Information</th>
                          <td>{{ $withdrawRequest->account_info }}</td>
                        </tr>
                      </tbody>
                    </table>

                    <div class="row mt-5">
                      <div class="col-md-3">
                        <form action="{{ route('admin.withdraw-list.update', $withdrawRequest->id) }}" method="POST">
                          @csrf
                          @method('PUT')
                          <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control" id="">
                              <option @selected($withdrawRequest->status == 'pending') value="pending">Pending</option>
                              <option @selected($withdrawRequest->status == 'paid') value="paid">Paid</option>
                              <option @selected($withdrawRequest->status == 'decline') value="decline">Declined</option>
                            </select>
                          </div>
                          <button class="btn btn-primary">Save</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

@endsection


