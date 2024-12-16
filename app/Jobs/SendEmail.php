<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Queueable;

    public $subject;
    public $message;
    public $email;

    public function __construct($subject, $message, $email)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->email = $email;
    }


    public function handle(): void
    {
        Mail::raw($this->message, function ($message) {
            $message->to($this->email)
                ->subject($this->subject);
        });
    }
}
