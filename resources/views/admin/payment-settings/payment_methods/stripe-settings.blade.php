<div class="tab-pane fade" id="list-stripe" role="tabpanel" aria-labelledby="list-stripe-list">
  <div class="card border">
    <div class="card-body">
      <form action="{{ route('admin.stripe-settings.update', 1) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Stripe Status</label>
          <select name="status" class="form-control" id="">
            <option {{ $stripeSetting->status == 1 ? 'selected' : '' }} value="1">Enable</option>
            <option {{ $stripeSetting->status == 0 ? 'selected' : '' }} value="0">Disable</option>
          </select>
          @if ($errors->has('status'))
            <code>{{ $errors->first('status') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Account Mode</label>
          <select name="mode" class="form-control" id="">
            <option {{ $stripeSetting->mode == 0 ? 'selected' : '' }} value="0">Sandbox</option>
            <option {{ $stripeSetting->mode == 1 ? 'selected' : '' }} value="1">Live</option>
          </select>
          @if ($errors->has('mode'))
            <code>{{ $errors->first('mode') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Country</label>
          <select name="country_name" class="form-control select2" id="">
            <option value="">Select</option>
            @foreach (config('settings.country_list') as $country )
             <option {{ $stripeSetting->country_name == $country ? 'selected' : '' }} value="{{$country}}">{{$country}}</option>
            @endforeach
          </select>
          @if ($errors->has('country_name'))
            <code>{{ $errors->first('country_name') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Currency Name</label>
          <select name="currency_name" class="form-control select2" id="">
            <option value="">Select</option>
            @foreach (config('settings.currency_list') as $key => $currency )
             <option {{ $stripeSetting->currency_name == $currency ? 'selected' : '' }} value="{{$currency}}">{{$key}}</option>
            @endforeach
          </select>
          @if ($errors->has('currency_name'))
            <code>{{ $errors->first('currency_name') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Currency rate (Per {{ $settings->currency_name }})</label>
          <input type="text" name="currency_rate" class="form-control" value="{{ $stripeSetting->currency_rate }}">
          @if ($errors->has('currency_rate'))
            <code>{{ $errors->first('currency_rate') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Stripe Client Id</label>
          <input type="text" name="client_id" class="form-control" value="{{ $stripeSetting->client_id }}">
          @if ($errors->has('client_id'))
            <code>{{ $errors->first('client_id') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Stripe Secret Key</label>
          <input type="text" name="secret_key" class="form-control" value="{{ $stripeSetting->secret_key }}">
          @if ($errors->has('secret_key'))
            <code>{{ $errors->first('secret_key') }}</code>
          @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>

