@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Vendor Condition</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Condition</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.vendor-condition.update') }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Terms and Conditions</label>
                        <textarea name="content" class="summernote">{!! @$content->content !!}</textarea>
                        @if ($errors->has('content'))
                          <code>{{ $errors->first('content') }}</code>
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

