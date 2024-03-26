<div class="tab-pane fade show active" id="general-settings" role="tabpanel" aria-labelledby="list-home-list">
  <div class="card border">
    <div class="card-body">
      <form action="{{ route('admin.general-settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group" style="margin-bottom: 1rem">
          <label >Site Name</label>
          <input type="text" name="site_name" class="form-control" value="{{ @$generalSettings->site_name }}">
          @if ($errors->has('site_name'))
            <code>{{ $errors->first('site_name') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Layout</label>
          <select name="layout" class="form-control" id="">
            <option {{ $generalSettings->layout == 'ltr' ? 'selected' : '' }} value="ltr">LTR</option>
            <option {{ $generalSettings->layout == 'rtl' ? 'selected' : '' }} value="rtl">RTL</option>
          </select>
          @if ($errors->has('layout'))
            <code>{{ $errors->first('layout') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Contact Email</label>
          <input type="email" name="contact_email" class="form-control" value="{{ @$generalSettings->contact_email }}">
          @if ($errors->has('contact_email'))
            <code>{{ $errors->first('contact_email') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Default Currency Name</label>
          <select name="currency_name" class="form-control select2" id="">
            <option value="">Select</option>
            @foreach (config('settings.currency_list') as $currency )
              <option {{ @$generalSettings->currency_name == $currency ? 'selected' : '' }} value="{{ $currency }}">{{ $currency }}</option>
            @endforeach
          </select>
          @if ($errors->has('currency_name'))
            <code>{{ $errors->first('currency_name') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Currency Icon</label>
          <input type="text" name="currency_icon" class="form-control" value="{{ @$generalSettings->currency_icon }}">
          @if ($errors->has('currency_icon'))
            <code>{{ $errors->first('currency_icon') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label>Timezone</label>
          <select name="time_zone" class="form-control select2" id="">
            <option value="">Select</option>
            @foreach (config('settings.time_zone') as $key => $timeZone )
             <option {{ @$generalSettings->time_zone == $key ? 'selected' : '' }} value="{{ $key }}">{{ $key }}</option>
            @endforeach
          </select>
          @if ($errors->has('time_zone'))
            <code>{{ $errors->first('time_zone') }}</code>
          @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>
