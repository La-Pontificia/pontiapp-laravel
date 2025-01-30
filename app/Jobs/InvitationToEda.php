<?php

namespace App\Jobs;

use App\Mail\InvitationToEdaMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class InvitationToEda implements ShouldQueue
{
    use Queueable;

    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function handle(): void
    {
        $user = User::find($this->userId);
        if ($user) {
            Mail::to($user->email)->send(new InvitationToEdaMail($user));
        }
    }
}
