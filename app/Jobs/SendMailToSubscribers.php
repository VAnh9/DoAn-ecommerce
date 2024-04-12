<?php

namespace App\Jobs;

use App\Mail\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailToSubscribers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $emails, $subject, $content;

    /**
     * Create a new job instance.
     */
    public function __construct($emails, $subject, $content)
    {
      $this->emails = $emails;
      $this->subject = $subject;
      $this->content = $content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      Mail::to($this->emails)->send(new Newsletter($this->subject, $this->content));
    }
}
