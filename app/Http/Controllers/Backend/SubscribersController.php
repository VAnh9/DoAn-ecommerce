<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\NewsletterSubscriberDataTable;
use App\Http\Controllers\Controller;
use App\Jobs\SendMailToSubscribers;
use App\Mail\Newsletter;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscribersController extends Controller
{
  public function index(NewsletterSubscriberDataTable $dataTable)
  {
    return $dataTable->render('admin.subscriber.index');
  }

  public function destroy($id)
  {
    $subsciber = NewsletterSubscriber::findOrFail($id);

    $subsciber->delete();

    return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
  }

  public function sendMail(Request $request)
  {
    $request->validate([
      'subject' => ['required'],
      'message' => ['required'],
    ]);

    $emails = NewsletterSubscriber::where('is_verified', 1)->pluck('email')->toArray();

    SendMailToSubscribers::dispatch($emails, $request->subject, $request->message);

    toastr('Mail has been sent!');

    return redirect()->back();

  }
}
