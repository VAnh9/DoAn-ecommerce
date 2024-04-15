

@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header justify-content-between">
            <h1>Vendor Infomation</h1>
            <a href="{{ route('admin.vendor-request.index') }}" class="btn btn-secondary">Back</a>
          </div>

          <div class="section-body">
            <div class="invoice" id="invoice">
              <div class="invoice-print">
                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tr>
                          <th>User Name:</th>
                          <td>{{ $vendor->user->name }}</td>
                        </tr>
                        <tr>
                          <th>User Email:</th>
                          <td>{{ $vendor->user->email }}</td>
                        </tr>
                        <tr>
                          <th>Shop Name:</th>
                          <td>{{ $vendor->name }}</td>
                        </tr>
                        <tr>
                          <th>Shop Email:</th>
                          <td>{{ $vendor->email }}</td>
                        </tr>
                        <tr>
                          <th>Shop Phone:</th>
                          <td>{{ $vendor->phone }}</td>
                        </tr>
                        <tr>
                          <th>Shop Addess:</th>
                          <td>{{ $vendor->address }}</td>
                        </tr>
                        <tr>
                          <th>Description:</th>
                          <td>{{ $vendor->description }}</td>
                        </tr>
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="col-md-4">
                          <form action="{{ route('admin.vendor-request.change-status', $vendor->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                              <label for="">Request Status</label>
                              <select name="status" class="form-control">
                                <option {{ $vendor->status == 0 ? 'selected' : '' }} value="0">Pending</option>
                                <option {{ $vendor->status == 1 ? 'selected' : '' }} value="1">Approved</option>
                              </select>
                            </div>

                            <button class="btn btn-primary">Update</button>
                          </form>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

@endsection


<style>
  table tr {
    height: 40px;
    line-height: 40px;
  }
  table th {
    width: 150px;
  }
</style>
