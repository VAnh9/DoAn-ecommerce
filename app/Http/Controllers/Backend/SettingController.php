<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Symfony\Component\Intl\Currencies;

class SettingController extends Controller
{
  public function index()
  {

    $generalSettings = GeneralSetting::first();
    $emailConfig = EmailConfiguration::first();
    return view('admin.settings.index', compact('generalSettings', 'emailConfig'));
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


  public function getCurrencySymbol(Request $request)
  {

    $symbol = Currencies::getSymbol($request->currencyCode);

    return $symbol;
  }
}
