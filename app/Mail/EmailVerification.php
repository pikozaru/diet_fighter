<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('【activity】登録手続きのご案内')
            ->view('view.pre_register')
            ->with(['token' => $this->user->verification_token, ]);
    }
}
