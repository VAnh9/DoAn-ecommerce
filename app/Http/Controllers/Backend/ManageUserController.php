<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailWhenAccountCreated;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{
  public function index()
  {
    return view('admin.manage-user.index');
  }

  public function create(Request $request)
  {
    $request->validate([
      'name' => ['required', 'max:200'],
      'email' => ['required', 'email', 'unique:users,email'],
      'password' => ['required', 'min:8', 'confirmed'],
      'role' => ['required'],
      'phone' => ['required_if:role,shipper', 'max:20']
    ]);

    $user = new User();

    if($request->role == 'user') {
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->role = 'user';
      $user->status = 'active';

      $user->save();

      SendMailWhenAccountCreated::dispatch($request->name, $request->email, $request->password);

      toastr('Created Successfully!');

      return redirect()->back();
    }
    else if($request->role == 'vendor') {
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->role = 'vendor';
      $user->status = 'active';
      $user->save();

      $vendor = new Vendor();
      $vendor->banner = 'uploads/123.jpg';
      $vendor->name = $request->name.' Shop';
      $vendor->phone = '+11111111';
      $vendor->email = $request->email;
      $vendor->address = 'shop address';
      $vendor->description = 'shop descritpion';
      $vendor->user_id = $user->id;
      $vendor->status = 1;
      $vendor->save();

      SendMailWhenAccountCreated::dispatch($request->name, $request->email, $request->password);


      toastr('Created Successfully!');

      return redirect()->back();
    }
    else if($request->role == 'admin') {
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->role = 'admin';
      $user->status = 'active';
      $user->save();

      $vendor = new Vendor();
      $vendor->banner = 'uploads/123.jpg';
      $vendor->name = $request->name.' Shop';
      $vendor->phone = '+11111111';
      $vendor->email = $request->email;
      $vendor->address = 'shop address';
      $vendor->description = 'shop descritpion';
      $vendor->user_id = $user->id;
      $vendor->status = 1;
      $vendor->save();

      SendMailWhenAccountCreated::dispatch($request->name, $request->email, $request->password);

      toastr('Created Successfully!');

      return redirect()->back();
    }
    else if($request->role == 'shipper') {
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->role = 'shipper';
      $user->status = 'active';
      $user->phone = $request->phone;

      $user->save();

      SendMailWhenAccountCreated::dispatch($request->name, $request->email, $request->password);

      toastr('Created Successfully!');

      return redirect()->back();
    }
  }
}
