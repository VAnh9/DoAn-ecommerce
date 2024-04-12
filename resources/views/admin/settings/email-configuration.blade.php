<div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
  <div class="card border">
    <div class="card-body">
      <form action="{{ route('admin.email-configuration-update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Email</label>
          <input type="email" name="email" class="form-control" value="{{ $emailConfig->email }}">
          @if ($errors->has('email'))
            <code>{{ $errors->first('email') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Mail Host</label>
          <input type="text" name="host" class="form-control" value="{{ $emailConfig->host }}">
          @if ($errors->has('host'))
            <code>{{ $errors->first('host') }}</code>
          @endif
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Smtp Username</label>
              <input type="text" name="username" class="form-control" value="{{ $emailConfig->username }}">
              @if ($errors->has('username'))
                <code>{{ $errors->first('username') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Smtp Password</label>
              <input type="text" name="password" class="form-control" value="{{ $emailConfig->password }}">
              @if ($errors->has('password'))
                <code>{{ $errors->first('password') }}</code>
              @endif
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Mail Port</label>
              <input type="text" name="port" class="form-control" value="{{ $emailConfig->port }}">
              @if ($errors->has('port'))
                <code>{{ $errors->first('port') }}</code>
              @endif
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 1rem">
              <label>Mail Encryption</label>
              <select name="encryption" id="" class="form-control">
                <option {{ $emailConfig->encryption == 'tls' ? 'selected' : '' }} value="tls">TLS</option>
                <option {{ $emailConfig->encryption == 'ssl' ? 'selected' : '' }} value="ssl">SSL</option>
              </select>
              @if ($errors->has('encryption'))
                <code>{{ $errors->first('encryption') }}</code>
              @endif
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>
