<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BroadcastMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($messageContent, $user = null)
    {
        $this->messageContent = $messageContent;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.broadcast-message')
                    ->subject('Pesan Penting dari LaundryEase')
                    ->with([
                        'messageContent' => $this->messageContent,
                        'user' => $this->user,
                        'appName' => config('app.name', 'LaundryEase'),
                    ]);
    }
}
