@php
  $homepageBannerSectionFour = json_decode($homepageBannerSectionFour->value, true)['banner_one'];
@endphp
<div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
  <div class="card border">
    <div class="card-body">
      <form action="{{ route('admin.advertisement.homepage-banner-section-four') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group d-flex align-items-center" style="margin-bottom: 1rem">
          <label for="">Status</label>
          <label class="custom-switch ml-2">
            <input type="checkbox" {{ @$homepageBannerSectionFour['status'] == 1 ? 'checked' : '' }} name="status" class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
          </label>
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <img src="{{ asset(@$homepageBannerSectionFour['banner_image'])}}" alt="" width="200px">
          <br>
          <label >Banner Image</label>
          <input type="file" name="banner_image" class="form-control" value="">
          @if ($errors->has('banner_image'))
            <code>{{ $errors->first('banner_image') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label >Banner Url</label>
          <input type="text" name="banner_url" class="form-control" value="{{ @$homepageBannerSectionFour['banner_url'] }}">
          @if ($errors->has('banner_url'))
            <code>{{ $errors->first('banner_url') }}</code>
          @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>
