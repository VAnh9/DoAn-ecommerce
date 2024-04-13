<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
  use ImageUploadTrait;

  public function index()
  {
    $homepageBannerOne = Advertisement::where('key', 'homepage_banner_section_one')->first();
    $homepageBannerSectionTwo = Advertisement::where('key', 'homepage_banner_section_two')->first();
    $homepageBannerSectionThree = Advertisement::where('key', 'homepage_banner_section_three')->first();
    $homepageBannerSectionFour = Advertisement::where('key', 'homepage_banner_section_four')->first();
    $productPageBanner = Advertisement::where('key', 'product_page_banner')->first();
    $cartPageBanner = Advertisement::where('key', 'cart_page_banner')->first();
    $flashsalePageBanner = Advertisement::where('key', 'flashsale_page_banner')->first();

    return view('admin.advertisement.index', compact(
      'homepageBannerOne',
      'homepageBannerSectionTwo',
      'homepageBannerSectionThree',
      'homepageBannerSectionFour',
      'productPageBanner',
      'cartPageBanner',
      'flashsalePageBanner'
    ));
  }

  public function homepageBannerSectionOne(Request $request)
  {
    $request->validate([
      'banner_image' => ['nullable', 'image'],
      'banner_url' => ['required']
    ]);

    $data = Advertisement::where('key', 'homepage_banner_section_one')->first();
    if ($data) {
      $data = json_decode($data->value, true);
    }

    $imagePath = $this->updateImage($request, 'banner_image', 'uploads', $data ? $data['banner_one']['banner_image'] : null);

    $value = [
      'banner_one' => [
        'banner_url' => $request->banner_url,
        'status' => $request->status == 'on' ? 1 : 0,
      ]
    ];

    if (!empty($imagePath)) {
      $value['banner_one']['banner_image'] = $imagePath;
    } else {

      $value['banner_one']['banner_image'] = $data ? $data['banner_one']['banner_image'] : '';
    }

    $value = json_encode($value);

    Advertisement::updateOrCreate(
      ['key' => 'homepage_banner_section_one'],
      ['value' => $value],
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }

  public function homepageBannerSectionTwo(Request $request)
  {
    $request->validate([
      'banner_one_image' => ['nullable', 'image'],
      'banner_one_url' => ['required'],
      'banner_two_image' => ['nullable', 'image'],
      'banner_two_url' => ['required']
    ]);


    $data = Advertisement::where('key', 'homepage_banner_section_two')->first();
    if ($data) {
      $data = json_decode($data->value, true);
    }

    $imagePathOne = $this->updateImage($request, 'banner_one_image', 'uploads', $data ? $data['banner_one']['banner_image'] : null);
    $imagePathTwo = $this->updateImage($request, 'banner_two_image', 'uploads', $data ? $data['banner_two']['banner_image'] : null);

    $value = [
      'banner_one' => [
        'banner_url' => $request->banner_one_url,
        'status' => $request->banner_one_status == 'on' ? 1 : 0,
      ],
      'banner_two' => [
        'banner_url' => $request->banner_two_url,
        'status' => $request->banner_two_status == 'on' ? 1 : 0,
      ]
    ];

    if (!empty($imagePathOne)) {
      $value['banner_one']['banner_image'] = $imagePathOne;
    } else {
      $value['banner_one']['banner_image'] = $data ? $data['banner_one']['banner_image'] : '';
    }

    if (!empty($imagePathTwo)) {
      $value['banner_two']['banner_image'] = $imagePathTwo;
    } else {
      $value['banner_two']['banner_image'] = $data ? $data['banner_two']['banner_image'] : '';
    }

    $value = json_encode($value);

    Advertisement::updateOrCreate(
      ['key' => 'homepage_banner_section_two'],
      ['value' => $value],
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }

  public function homepageBannerSectionThree(Request $request)
  {
    $request->validate([
      'banner_one_image' => ['nullable', 'image'],
      'banner_one_url' => ['required'],
      'banner_two_image' => ['nullable', 'image'],
      'banner_two_url' => ['required'],
      'banner_three_image' => ['nullable', 'image'],
      'banner_three_url' => ['required'],
    ]);


    $data = Advertisement::where('key', 'homepage_banner_section_three')->first();
    if ($data) {
      $data = json_decode($data->value, true);
    }

    $imagePathOne = $this->updateImage($request, 'banner_one_image', 'uploads', $data ? $data['banner_one']['banner_image'] : null);
    $imagePathTwo = $this->updateImage($request, 'banner_two_image', 'uploads', $data ? $data['banner_two']['banner_image'] : null);
    $imagePathThree = $this->updateImage($request, 'banner_three_image', 'uploads', $data ? $data['banner_three']['banner_image'] : null);

    $value = [
      'banner_one' => [
        'banner_url' => $request->banner_one_url,
        'status' => $request->banner_one_status == 'on' ? 1 : 0,
      ],
      'banner_two' => [
        'banner_url' => $request->banner_two_url,
        'status' => $request->banner_two_status == 'on' ? 1 : 0,
      ],
      'banner_three' => [
        'banner_url' => $request->banner_three_url,
        'status' => $request->banner_three_status == 'on' ? 1 : 0,
      ]
    ];

    if (!empty($imagePathOne)) {
      $value['banner_one']['banner_image'] = $imagePathOne;
    } else {
      $value['banner_one']['banner_image'] = $data ? $data['banner_one']['banner_image'] : '';
    }

    if (!empty($imagePathTwo)) {
      $value['banner_two']['banner_image'] = $imagePathTwo;
    } else {
      $value['banner_two']['banner_image'] = $data ? $data['banner_two']['banner_image'] : '';
    }

    if (!empty($imagePathThree)) {
      $value['banner_three']['banner_image'] = $imagePathThree;
    } else {
      $value['banner_three']['banner_image'] = $data ? $data['banner_three']['banner_image'] : '';
    }

    $value = json_encode($value);

    Advertisement::updateOrCreate(
      ['key' => 'homepage_banner_section_three'],
      ['value' => $value],
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }

  public function homepageBannerSectionFour(Request $request)
  {
    $request->validate([
      'banner_image' => ['nullable', 'image'],
      'banner_url' => ['required']
    ]);

    $data = Advertisement::where('key', 'homepage_banner_section_four')->first();
    if ($data) {
      $data = json_decode($data->value, true);
    }

    $imagePath = $this->updateImage($request, 'banner_image', 'uploads', $data ? $data['banner_one']['banner_image'] : null);

    $value = [
      'banner_one' => [
        'banner_url' => $request->banner_url,
        'status' => $request->status == 'on' ? 1 : 0,
      ]
    ];

    if (!empty($imagePath)) {
      $value['banner_one']['banner_image'] = $imagePath;
    } else {

      $value['banner_one']['banner_image'] = $data ? $data['banner_one']['banner_image'] : '';
    }

    $value = json_encode($value);

    Advertisement::updateOrCreate(
      ['key' => 'homepage_banner_section_four'],
      ['value' => $value],
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }

  public function productPageBanner(Request $request)
  {
    $request->validate([
      'banner_image' => ['nullable', 'image'],
      'banner_url' => ['required']
    ]);

    $data = Advertisement::where('key', 'product_page_banner')->first();
    if ($data) {
      $data = json_decode($data->value, true);
    }

    $imagePath = $this->updateImage($request, 'banner_image', 'uploads', $data ? $data['banner_one']['banner_image'] : null);

    $value = [
      'banner_one' => [
        'banner_url' => $request->banner_url,
        'status' => $request->status == 'on' ? 1 : 0,
      ]
    ];

    if (!empty($imagePath)) {
      $value['banner_one']['banner_image'] = $imagePath;
    } else {

      $value['banner_one']['banner_image'] = $data ? $data['banner_one']['banner_image'] : '';
    }

    $value = json_encode($value);

    Advertisement::updateOrCreate(
      ['key' => 'product_page_banner'],
      ['value' => $value],
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }

  public function cartPageBanner(Request $request)
  {
    $request->validate([
      'banner_one_image' => ['nullable', 'image'],
      'banner_one_url' => ['required'],
      'banner_two_image' => ['nullable', 'image'],
      'banner_two_url' => ['required']
    ]);


    $data = Advertisement::where('key', 'cart_page_banner')->first();
    if ($data) {
      $data = json_decode($data->value, true);
    }

    $imagePathOne = $this->updateImage($request, 'banner_one_image', 'uploads', $data ? $data['banner_one']['banner_image'] : null);
    $imagePathTwo = $this->updateImage($request, 'banner_two_image', 'uploads', $data ? $data['banner_two']['banner_image'] : null);

    $value = [
      'banner_one' => [
        'banner_url' => $request->banner_one_url,
        'status' => $request->banner_one_status == 'on' ? 1 : 0,
      ],
      'banner_two' => [
        'banner_url' => $request->banner_two_url,
        'status' => $request->banner_two_status == 'on' ? 1 : 0,
      ]
    ];

    if (!empty($imagePathOne)) {
      $value['banner_one']['banner_image'] = $imagePathOne;
    } else {
      $value['banner_one']['banner_image'] = $data ? $data['banner_one']['banner_image'] : '';
    }

    if (!empty($imagePathTwo)) {
      $value['banner_two']['banner_image'] = $imagePathTwo;
    } else {
      $value['banner_two']['banner_image'] = $data ? $data['banner_two']['banner_image'] : '';
    }

    $value = json_encode($value);

    Advertisement::updateOrCreate(
      ['key' => 'cart_page_banner'],
      ['value' => $value],
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }

  public function flashsalePageBanner(Request $request)
  {
    $request->validate([
      'banner_one_image' => ['nullable', 'image'],
      'banner_one_url' => ['required'],
      'banner_two_image' => ['nullable', 'image'],
      'banner_two_url' => ['required']
    ]);


    $data = Advertisement::where('key', 'flashsale_page_banner')->first();
    if ($data) {
      $data = json_decode($data->value, true);
    }

    $imagePathOne = $this->updateImage($request, 'banner_one_image', 'uploads', $data ? $data['banner_one']['banner_image'] : null);
    $imagePathTwo = $this->updateImage($request, 'banner_two_image', 'uploads', $data ? $data['banner_two']['banner_image'] : null);

    $value = [
      'banner_one' => [
        'banner_url' => $request->banner_one_url,
        'status' => $request->banner_one_status == 'on' ? 1 : 0,
      ],
      'banner_two' => [
        'banner_url' => $request->banner_two_url,
        'status' => $request->banner_two_status == 'on' ? 1 : 0,
      ]
    ];

    if (!empty($imagePathOne)) {
      $value['banner_one']['banner_image'] = $imagePathOne;
    } else {
      $value['banner_one']['banner_image'] = $data ? $data['banner_one']['banner_image'] : '';
    }

    if (!empty($imagePathTwo)) {
      $value['banner_two']['banner_image'] = $imagePathTwo;
    } else {
      $value['banner_two']['banner_image'] = $data ? $data['banner_two']['banner_image'] : '';
    }

    $value = json_encode($value);

    Advertisement::updateOrCreate(
      ['key' => 'flashsale_page_banner'],
      ['value' => $value],
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }
}
