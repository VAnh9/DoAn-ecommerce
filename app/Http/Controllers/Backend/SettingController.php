<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use App\Models\LogoSetting;
use App\Models\PusherSetting;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Symfony\Component\Intl\Currencies;

use function PHPUnit\Framework\isEmpty;

class SettingController extends Controller
{
  use ImageUploadTrait;
  public function index()
  {

    $generalSettings = GeneralSetting::first();
    $emailConfig = EmailConfiguration::first();
    $logoSettings = LogoSetting::first();
    $pusherSetting = PusherSetting::first();
    return view('admin.settings.index', compact('generalSettings', 'emailConfig', 'logoSettings', 'pusherSetting'));
  }

  public function updateGeneralSettings(Request $request)
  {

    $request->validate([
      'site_name' => ['required', 'max:200'],
      'layout' => ['required'],
      'contact_email' => ['required', 'max:200', 'email'],
      'currency_name' => ['required'],
      'currency_icon' => ['required', 'max:200'],
      'time_zone' => ['required']
    ]);

    GeneralSetting::updateOrCreate(
      ['id' => 1],
      [
        'site_name' => $request->site_name,
        'layout' => $request->layout,
        'contact_email' => $request->contact_email,
        'contact_phone' => $request->contact_phone,
        'contact_address' => $request->contact_address,
        'map' => $request->map,
        'currency_name' => $request->currency_name,
        'currency_icon' => $request->currency_icon,
        'time_zone' => $request->time_zone
      ]
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }

  public function emailConfigUpdate(Request $request)
  {
    $request->validate([
      'email' => ['required', 'email'],
      'host' => ['required', 'max:200'],
      'username' => ['required', 'max:200'],
      'password' => ['required', 'max:200'],
      'port' => ['required', 'max:200'],
      'encryption' => ['required', 'max:200'],
    ]);

    EmailConfiguration::updateOrCreate(
      ['id' => 1],
      [
        'email' => $request->email,
        'host' => $request->host,
        'username' => $request->username,
        'password' => $request->password,
        'port' => $request->port,
        'encryption' => $request->encryption,
      ]
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }

  public function updateLogoSetting(Request $request)
  {
    $request->validate([
      'logo' => ['nullable', 'image', 'max:3000'],
      'favicon' => ['nullable', 'image', 'max:3000'],
    ]);

    $logoSettings = LogoSetting::first();


    $logoPath = $this->updateImage($request, 'logo', 'uploads', isset($logoSettings) ? $logoSettings->logo : null);
    $faviconPath = $this->updateImage($request, 'favicon', 'uploads', isset($logoSettings) ? $logoSettings->favicon : null);

    LogoSetting::updateOrCreate(
      ['id' => 1],
      [
        'logo' => !empty($logoPath) ? $logoPath : ($logoSettings ? $logoSettings->logo : ''),
        'favicon' => !empty($faviconPath) ? $faviconPath : ($logoSettings ? $logoSettings->favicon : '')
      ]
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }


  public function getCurrencySymbol(Request $request)
  {

    $symbol = Currencies::getSymbol($request->currencyCode);

    return $symbol;
  }

  public function pusherSettting(Request $request)
  {
    $validatedData = $request->validate([
      'pusher_app_id' => ['required'],
      'pusher_key' => ['required'],
      'pusher_secret' => ['required'],
      'pusher_cluster' => ['required'],
    ]);


    PusherSetting::updateOrCreate(
      ['id' => 1],
      $validatedData
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }
}
