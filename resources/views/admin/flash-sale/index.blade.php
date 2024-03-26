@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Flash Sale</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Flash Sale End Date</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.flash-sale.update') }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                        <label>Sale End Date</label>
                        <input type="text" class="form-control datepicker {{ @$flashSale->end_date < now() ? 'expired' : '' }}" name="end_date" value="{{ @$flashSale->end_date }}">
                        @if ($errors->has('end_date'))
                          <code>{{ $errors->first('end_date') }}</code>
                        @endif
                      </div>

                      <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Add Flash Sale Products</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.flash-sale.add-product') }}" method="POST">
                      @csrf
                      <div class="form-group">
                        <label>Add Products</label>
                        <select name="products[]" id="" class="form-control select2" multiple>
                          {{-- <option value="" disabled selected hidden>Select</option> --}}
                          @foreach ($products as $product )
                            <option value="{{ $product->id }}">{{ $product->name}}</option>
                          @endforeach
                        </select>
                        @if ($errors->has('products'))
                          <code>{{ $errors->first('products') }}</code>
                        @endif
                        @if ($errors->has('products.*'))
                          <code>{{ $errors->first('products.*') }}</code>
                        @endif
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Show at home ?</label>
                            <select name="show_at_home" id="" class="form-control">
                              <option value="">Select</option>
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                            </select>
                            @if ($errors->has('show_at_home'))
                              <code>{{ $errors->first('show_at_home') }}</code>
                            @endif
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" id="" class="form-control">
                              <option selected value="1">Active</option>
                              <option value="0">Inactive</option>
                            </select>
                            @if ($errors->has('status'))
                              <code>{{ $errors->first('status') }}</code>
                            @endif
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Save</button>
                    </form>


                  </div>
                </div>
              </div>
            </div>


          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>All Flash Sale Products</h4>
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
          url: "{{ route('admin.flash-sale-status') }}",
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

      /* change show at home status */
      $('body').on('click', '.change-at-home-status', function() {
        let isChecked = $(this).is(':checked');
        let id = $(this).data('id');
        $.ajax({
          url: "{{ route('admin.flash-sale.show-at-home.change-status') }}",
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

<style>
  .expired {
    border-color: red !important;
  }
</style>

