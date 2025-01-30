<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationToEdaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('PontiApp – Gestión de EDAs')
            ->view('emails.invitationToEda')
            ->with([
                'user' => $this->user,
            ]);
    }
}
