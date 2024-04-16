<?php

namespace App\Jobs;

use App\Helper\MailHelper;
use App\Mail\AccountCreatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailWhenAccountCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $name, $email, $password;

    /**
     * Create a new job instance.
     */
    public function __construct($name, $email, $password)
    {
      $this->name = $name;
      $this->email = $email;
      $this->password = $password;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      MailHelper::setMailConfig();
      Mail::to($this->email)->send(new AccountCreatedMail($this->name, $this->email, $this->password));
    }
}
