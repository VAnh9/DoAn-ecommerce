<div class="tab-pane fade" id="pusher-setting" role="tabpanel" aria-labelledby="list-pusher-list">
  <div class="card border">
    <div class="card-body">
      <form action="{{ route('admin.puhser-setting-update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Pusher App Id</label>
          <input type="text" name="pusher_app_id" class="form-control" value="{{ @$pusherSetting->pusher_app_id }}">
          @if ($errors->has('pusher_app_id'))
            <code>{{ $errors->first('pusher_app_id') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Pusher Key</label>
          <input type="text" name="pusher_key" class="form-control" value="{{ @$pusherSetting->pusher_key }}">
          @if ($errors->has('pusher_key'))
            <code>{{ $errors->first('pusher_key') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Pusher Secret</label>
          <input type="text" name="pusher_secret" class="form-control" value="{{ @$pusherSetting->pusher_secret }}">
          @if ($errors->has('pusher_secret'))
            <code>{{ $errors->first('pusher_secret') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Pusher Cluster</label>
          <input type="text" name="pusher_cluster" class="form-control" value="{{ @$pusherSetting->pusher_cluster }}">
          @if ($errors->has('pusher_cluster'))
            <code>{{ $errors->first('pusher_cluster') }}</code>
          @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>
