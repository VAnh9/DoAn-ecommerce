<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

trait ImageUploadTrait
{

  public function uploadImage(Request $request, $inputName, $path, $for = null)
  {
    if ($request->hasFile($inputName)) {

      $imageTaken = $request->{$inputName};
      $ext = $imageTaken->getClientOriginalExtension();
      $imageName = 'media_' . uniqid() . '.' . $ext;

      $this->resizeImageAndStore($for, $imageTaken, $path, $imageName);

      return $path . '/' . $imageName;
    }
  }

  public function uploadMultiImage(Request $request, $inputName, $path)
  {
    $paths = [];

    if ($request->hasFile($inputName)) {

      $images = $request->{$inputName};

      foreach ($images as $image) {

        $ext = $image->getClientOriginalExtension();

        $imageName = 'media_' . uniqid() . '.' . $ext;

        $image->move(public_path($path), $imageName);

        $paths[] = $path . '/' . $imageName;
      }
    }
    return $paths;
  }

  public function updateImage(Request $request, $inputName, $path, $oldPath = null, $for = null)
  {
    if ($request->hasFile($inputName)) {
      if (File::exists(public_path($oldPath))) {
        File::delete(public_path($oldPath));
      }

      $imageTaken = $request->{$inputName};
      $ext = $imageTaken->getClientOriginalExtension();
      $imageName = 'media_' . uniqid() . '.' . $ext;

      $this->resizeImageAndStore($for, $imageTaken, $path, $imageName);

      return $path . '/' . $imageName;
    }
  }

  public function deleteImage(string $path)
  {
    if (File::exists(public_path($path))) {
      File::delete(public_path($path));
    }
  }

  public function resizeImageAndStore($type, $imageTaken, $path, $imageName)
  {
    if (isset($type)) {

      $manage = new ImageManager(new Driver());

      $image = $manage->read($imageTaken);

      if ($type == 'brand') {

        $image = $image->resize(1280, 640);

      } else if ($type == 'blog') {

        $image = $image->resize(520, 396);

      } else if($type == 'slider') {

        $image = $image->resize(1300, 500);

      } else if($type == 'banner_store') {

        $image = $image->resize(590, 414);

      } else if($type == 'product') {

        $image = $image->resize(380, 317);

      }

      $image->save(public_path($path) . '/' . $imageName);
    }
    else {
      $imageTaken->move(public_path($path), $imageName);
    }
  }
}
