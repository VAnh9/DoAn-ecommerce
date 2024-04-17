<div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
  <div class="card border">
    <div class="card-body">
      <form action="{{ route('admin.logo-setting-update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 1rem">
          <img src="{{ asset(@$logoSettings->logo) }}" width="150px" alt="">
          <br>
          <label>Logo</label>
          <input type="file" name="logo" class="form-control" value="">
          @if ($errors->has('logo'))
            <code>{{ $errors->first('logo') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <img src="{{ asset(@$logoSettings->favicon) }}" width="150px" alt="">
          <br>
          <label>Favicon</label>
          <input type="file" name="favicon" class="form-control" value="">
          @if ($errors->has('favicon'))
            <code>{{ $errors->first('favicon') }}</code>
          @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>
