<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserVendorRequestController extends Controller
{
  use ImageUploadTrait;

  public function index() {
    return view('frontend.dashboard.vendor-request.index');
  }

  public function store(Request $request) {
    $request->validate([
      'banner' => ['required', 'image', 'max:3000'],
      'name' => ['required', 'max:200'],
      'email' => ['required', 'email'],
      'phone' => ['required', 'max:20'],
      'address' => ['required'],
      'description' => ['required']
    ]);

    $imagePath = $this->uploadImage($request, 'banner', 'uploads');

    $vendor = new Vendor();

    $vendor->banner = $imagePath;
    $vendor->name = $request->name;
    $vendor->phone = $request->phone;
    $vendor->email = $request->email;
    $vendor->address = $request->address;
    $vendor->description = $request->description;
    $vendor->user_id = Auth::user()->id;
    $vendor->status = 0;

    $vendor->save();

    toastr('Submitted successfully. Please wait for approve!');

    return redirect()->back();

  }
}
