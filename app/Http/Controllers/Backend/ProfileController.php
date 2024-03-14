<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    use ImageUploadTrait;
    public function index() {

        return view('admin.profile.index');
    }

    public function updateProfile(Request $request) {

        $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email,'.Auth::user()->id],
            'image' => ['image', 'max:2048'],
            'username' => ['max:12'],
        ]);

        $user = Auth::user();

        if($request->hasFile('image')) {

            if(File::exists(public_path($user->image))) {
                File::delete(public_path($user->image));
            }

            $image = $request->image;

            $imageName = rand().'_'.$image->getClientOriginalName();

            $image->move(public_path('uploads'), $imageName);

            $path = "/uploads/".$imageName;

            $user->image = $path;
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->username = $request->username;

        /** @disregard P1013 */
        $user->save();

        toastr()->success('Profile Updated Successfully');

        return redirect()->back();
    }

    /** Update password */
    public function updatePassword(Request $request) {

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);

        toastr()->success('Profile Password Updated Successfully');

        return redirect()->back();
    }
}
