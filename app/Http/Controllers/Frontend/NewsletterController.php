<?php

namespace App\Http\Controllers\Frontend;

use App\Helper\MailHelper;
use App\Http\Controllers\Controller;
use App\Mail\SubscriptionVerification;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Str;

class NewsletterController extends Controller
{
  public function requestNewsletter(Request $request)
  {
    $request->validate([
      'email' => ['required', 'email']
    ]);

    $isExistsubscriber = NewsletterSubscriber::where('email', $request->email)->first();

    if (!empty($isExistsubscriber)) {
      if ($isExistsubscriber->is_verified == 0) {

        /** @disregard P1009 */
        $isExistsubscriber->verified_token = Str::random(25);

        $isExistsubscriber->save();

              //set mail config
        MailHelper::setMailConfig();
        // send mail to verify
        Mail::to($isExistsubscriber->email)->send(new SubscriptionVerification($isExistsubscriber));

        return response(['status' => 'success', 'message' => 'A verification link has been sent to your email. Pleas check!']);

      } else if ($isExistsubscriber->is_verified == 1) {
        return response(['status' => 'error', 'message' => 'This email has been subscribed!']);
      }
    } else {
      $subscriber = new NewsletterSubscriber();

      $subscriber->email = $request->email;
      /** @disregard P1009 */
      $subscriber->verified_token = Str::random(25);
      $subscriber->is_verified = 0;

      $subscriber->save();

      //set mail config
      MailHelper::setMailConfig();
      // send mail to verify
      Mail::to($subscriber->email)->send(new SubscriptionVerification($subscriber));

      return response(['status' => 'success', 'message' => 'A verification link has been sent to your email. Pleas check!']);
    }
  }

  public function verifyNewsletterEmail($token)
  {
    $verify = NewsletterSubscriber::where('verified_token', $token)->first();

    if($verify) {
      $verify->verified_token = 'verified';
      $verify->is_verified = 1;

      $verify->save();

      toastr('Email verification successfully. Thank you for subscription!');

      return redirect()->route('home');
    }
    else {
      toastr('Something went wrong. Please try again later!', 'error');

      return redirect()->route('home');
    }
  }
}
