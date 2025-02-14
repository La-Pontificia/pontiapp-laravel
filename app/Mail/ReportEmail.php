<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $module;
    public $description;
    public $downloadLink;
    public $user;

    public function __construct($subject, $module, $description, $downloadLink, $user)
    {
        $this->subject = $subject;
        $this->module = $module;
        $this->description = $description;
        $this->downloadLink = $downloadLink;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject($this->subject)
            ->view('reports.email')
            ->with([
                'user' => $this->user,
                'downloadLink' => $this->downloadLink,
                'module' => $this->module,
                'description' => $this->description,
            ]);
    }
}
