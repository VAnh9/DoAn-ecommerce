@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Coupon</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Create Coupon</h4>
                    <div class="card-header-action">
                      <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                      @csrf

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Name</label>
                        <input type="text"  name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                          <code>{{ $errors->first('name') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Code</label>
                        <input type="text"  name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}">
                        @if ($errors->has('code'))
                          <code>{{ $errors->first('code') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Quantity</label>
                        <input type="text"  name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}">
                        @if ($errors->has('quantity'))
                          <code>{{ $errors->first('quantity') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Max Use Per Person</label>
                        <input type="text"  name="max_use" class="form-control @error('max_use') is-invalid @enderror" value="{{ old('max_use') }}">
                        @if ($errors->has('max_use'))
                          <code>{{ $errors->first('max_use') }}</code>
                        @endif
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label>Start Date</label>
                            <input type="text"  name="start_date" class="form-control datepicker @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                            @if ($errors->has('start_date'))
                              <code>{{ $errors->first('start_date') }}</code>
                            @endif
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label>End Date</label>
                            <input type="text"  name="end_date" class="form-control datepicker @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                            @if ($errors->has('end_date'))
                              <code>{{ $errors->first('end_date') }}</code>
                            @endif
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label for="inputState">Discount Type</label> <br>
                             <select name="discount_type" id="inputState" class="form-control">
                                <option value="percent">Percentage (%)</option>
                                <option value="amount">Amount ({{ $settings->currency_icon }})</option>
                             </select>
                             @if ($errors->has('discount_type'))
                              <code>{{ $errors->first('discount_type') }}</code>
                            @endif
                          </div>
                        </div>

                        <div class="col-md-8">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label>Discount Value</label>
                            <input type="text"  name="discount_value" class="form-control @error('discount_value') is-invalid @enderror" value="{{ old('discount_value') }}">
                            @if ($errors->has('discount_value'))
                              <code>{{ $errors->first('discount_value') }}</code>
                            @endif
                          </div>
                        </div>
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Status</label>
                         <select name="status" id="inputState" class="form-control ">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                         </select>
                         @if ($errors->has('status'))
                          <code>{{ $errors->first('status') }}</code>
                        @endif
                      </div>

                      <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

@endsection


