@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Withdraw Methods</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Method</h4>
                    <div class="card-header-action">
                      <a href="{{ route('admin.withdraw.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.withdraw.update', $withdraw->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Name</label>
                        <input type="text" id="type" name="name" class="form-control" value="{{ $withdraw->name }}">
                        @if ($errors->has('name'))
                          <code>{{ $errors->first('name') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Minimum Amount</label>
                        <input type="text" name="minimum_amount" class="form-control" value="{{ $withdraw->minimum_amount }}">
                        @if ($errors->has('minimum_amount'))
                          <code>{{ $errors->first('minimum_amount') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Maximum Amount</label>
                        <input type="text" name="maximum_amount" class="form-control" value="{{ $withdraw->maximum_amount }}">
                        @if ($errors->has('maximum_amount'))
                          <code>{{ $errors->first('maximum_amount') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="serial">Withdraw Charge (%)</label>
                        <input type="text" name="withdraw_charge" class="form-control" value="{{ $withdraw->withdraw_charge }}">
                        @if ($errors->has('withdraw_charge'))
                          <code>{{ $errors->first('withdraw_charge') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Description</label>
                        <textarea name="description" id="" class="summernote-simple">{{ $withdraw->description }}</textarea>
                        @if ($errors->has('description'))
                          <code>{{ $errors->first('description') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Status</label>
                         <select name="status" id="inputState" class="form-control">
                            <option {{ $withdraw->status == 1 ? 'selected' : 0 }} value="1">Active</option>
                            <option {{ $withdraw->status == 0 ? 'selected' : 0 }} value="0">Inactive</option>
                         </select>
                         @if ($errors->has('status'))
                          <code>{{ $errors->first('status') }}</code>
                        @endif
                      </div>

                      <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>



@endsection

<style>
  .note-editor.note-frame.card {
    margin-bottom: 0;
  }
</style>
