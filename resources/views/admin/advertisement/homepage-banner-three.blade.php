@php
  $homepageBannerOne = json_decode($homepageBannerSectionThree->value, true)['banner_one'];
  $homepageBannerTwo = json_decode($homepageBannerSectionThree->value, true)['banner_two'];
  $homepageBannerThree = json_decode($homepageBannerSectionThree->value, true)['banner_three'];
@endphp
<div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
  <div class="card border">
    <div class="card-body">
      <form action="{{ route('admin.advertisement.homepage-banner-section-three') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h5>Banner one</h5>
        <div class="form-group d-flex align-items-center" style="margin-bottom: 1rem">
          <label for="">Status</label>
          <label class="custom-switch ml-2">
            <input type="checkbox" {{ @$homepageBannerOne['status'] == 1 ? 'checked' : '' }} name="banner_one_status" class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
          </label>
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <img src="{{ asset(@$homepageBannerOne['banner_image'])}}" alt="" width="200px">
          <br>
          <label >Banner Image</label>
          <input type="file" name="banner_one_image" class="form-control" value="">
          @if ($errors->has('banner_one_image'))
            <code>{{ $errors->first('banner_one_image') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label >Banner Url</label>
          <input type="text" name="banner_one_url" class="form-control" value="{{ @$homepageBannerOne['banner_url'] }}">
          @if ($errors->has('banner_one_url'))
            <code>{{ $errors->first('banner_one_url') }}</code>
          @endif
        </div>

        <hr>
        <h5>Banner two</h5>
        <div class="form-group d-flex align-items-center" style="margin-bottom: 1rem">
          <label for="">Status</label>
          <label class="custom-switch ml-2">
            <input type="checkbox" {{ @$homepageBannerTwo['status'] == 1 ? 'checked' : '' }} name="banner_two_status" class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
          </label>
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <img src="{{ asset(@$homepageBannerTwo['banner_image'])}}" alt="" width="200px">
          <br>
          <label >Banner Image</label>
          <input type="file" name="banner_two_image" class="form-control" value="">
          @if ($errors->has('banner_two_image'))
            <code>{{ $errors->first('banner_two_image') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label >Banner Url</label>
          <input type="text" name="banner_two_url" class="form-control" value="{{ @$homepageBannerTwo['banner_url'] }}">
          @if ($errors->has('banner_two_url'))
            <code>{{ $errors->first('banner_two_url') }}</code>
          @endif
        </div>

        <hr>
        <h5>Banner three</h5>
        <div class="form-group d-flex align-items-center" style="margin-bottom: 1rem">
          <label for="">Status</label>
          <label class="custom-switch ml-2">
            <input type="checkbox" {{ @$homepageBannerThree['status'] == 1 ? 'checked' : '' }} name="banner_three_status" class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
          </label>
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <img src="{{ asset(@$homepageBannerThree['banner_image'])}}" alt="" width="200px">
          <br>
          <label >Banner Image</label>
          <input type="file" name="banner_three_image" class="form-control" value="">
          @if ($errors->has('banner_three_image'))
            <code>{{ $errors->first('banner_three_image') }}</code>
          @endif
        </div>

        <div class="form-group" style="margin-bottom: 1rem">
          <label >Banner Url</label>
          <input type="text" name="banner_three_url" class="form-control" value="{{ @$homepageBannerThree['banner_url'] }}">
          @if ($errors->has('banner_three_url'))
            <code>{{ $errors->first('banner_three_url') }}</code>
          @endif
        </div>


        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>
