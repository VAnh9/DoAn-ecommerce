<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CodSetting;
use Illuminate\Http\Request;

class CodSettingsController extends Controller
{
  public function update(Request $request, string $id)
  {
    $request->validate([
      'status' => ['required', 'integer'],
    ]);

    CodSetting::updateOrCreate(
      ['id' => $id],
      [
        'status' => $request->status,
      ]
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }
}
