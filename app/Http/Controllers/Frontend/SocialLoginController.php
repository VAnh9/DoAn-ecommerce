<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Str;

class SocialLoginController extends Controller
{
  /** Login with goole */
  public function googlePage()
  {
    return Socialite::driver('google')->redirect();
  }

  public function googleCallback()
  {
    try {
      $user = Socialite::driver('google')->user();

      $existingUser = User::where('google_id', $user->id)->first();

      if($existingUser)
      {
        Auth::login($existingUser, true);

        return redirect()->route('user.dashboard');
      }
      else {
        $user = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'google_id'=> $user->id,
            /** @disregard P1009 */
            'password' => bcrypt(Str::random(24))
          ]);

        Auth::login($user, true);

        return redirect()->route('user.dashboard');

      }
    } catch (Exception $e) {
      toastr($e->getMessage(), 'error');
    }
  }

  /** Login with facebook */
  public function facebookPage()
  {
    return Socialite::driver('facebook')->redirect();
  }

  public function facebookCallback()
  {
    try {
      $user = Socialite::driver('facebook')->user();

      $existingUser = User::where('facebook_id', $user->id)->first();

      if($existingUser)
      {
        Auth::login($existingUser, true);

        return redirect()->route('user.dashboard');
      }
      else {
        $user = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'facebook_id'=> $user->id,
            /** @disregard P1009 */
            'password' => bcrypt(Str::random(24))
          ]);

        Auth::login($user, true);

        return redirect()->route('user.dashboard');

      }
    } catch (Exception $e) {
      toastr($e->getMessage(), 'error');
    }
  }
}
