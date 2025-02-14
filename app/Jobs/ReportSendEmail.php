<?php

namespace App\Jobs;

use App\Mail\ReportEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class ReportSendEmail implements ShouldQueue
{
    use Queueable;

    public $subject;
    public $module;
    public $description;
    public $downloadLink;
    public $userId;

    public function __construct($subject, $module, $description, $downloadLink, $userId)
    {
        $this->subject = $subject;
        $this->module = $module;
        $this->description = $description;
        $this->downloadLink = $downloadLink;
        $this->userId = $userId;
    }
    public function handle(): void
    {
        $user = User::find($this->userId);
        if ($user) {
            Mail::to($user->email)->send(new ReportEmail($this->subject, $this->module, $this->description, $this->downloadLink, $user));
        }
    }
}
