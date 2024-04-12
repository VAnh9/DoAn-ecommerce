@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Subscriber</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Send Email to all subscribers</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.subscribers-send-email') }}" method="POST">
                      @csrf
                      <div class="form-group">
                        <label for="">Subject</label>
                        <input type="text" class="form-control" name="subject">
                        @if ($errors->has('subject'))
                          <code>{{ $errors->first('subject') }}</code>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="">Message</label>
                        <textarea name="message" class="form-control" id="" cols="30" rows="10"></textarea>
                        @if ($errors->has('message'))
                          <code>{{ $errors->first('message') }}</code>
                        @endif
                      </div>
                      <button type="submit" class="btn btn-primary">Send</button>
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
                    <h4>All Subscribers</h4>
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

@endpush

