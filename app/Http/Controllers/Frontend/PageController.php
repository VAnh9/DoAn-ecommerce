<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\Contact;
use App\Models\AboutPage;
use App\Models\EmailConfiguration;
use App\Models\TermAndCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
  public function about()
  {
    $about = AboutPage::first();
    return view('frontend.pages.about', compact('about'));
  }

  public function termsAndConditions()
  {
    $terms = TermAndCondition::first();
    return view('frontend.pages.terms-and-conditions', compact('terms'));
  }

  public function contact()
  {
    return view('frontend.pages.contact');
  }

  public function handleContactForm(Request $request)
  {
    $request->validate([
      'name' => ['required', 'max:200'],
      'email' => ['required', 'email'],
      'subject' => ['required', 'max:200'],
      'message' => ['required']
    ]);

    $setting = EmailConfiguration::first();

    Mail::to($setting->email)->send(new Contact($request->subject, $request->message, $request->email));

    return response(['status' => 'success', 'message' => 'Mail sent successfully!']);
  }
}
