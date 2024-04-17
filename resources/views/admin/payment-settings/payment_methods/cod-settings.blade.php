<div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
  <div class="card border">
    <div class="card-body">
      <form action="{{ route('admin.cod-settings.update', 1) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 1rem">
          <label>COD Status</label>
          <select name="status" class="form-control" id="">
            <option {{ @$codSetting->status == 1 ? 'selected' : '' }} value="1">Enable</option>
            <option {{ @$codSetting->status == 0 ? 'selected' : '' }} value="0">Disable</option>
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
