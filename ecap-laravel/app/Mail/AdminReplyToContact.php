<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminReplyToContact extends Mailable
{
    use Queueable, SerializesModels;

    public $contactMessage;
    public $replyBody;

    public function __construct(ContactMessage $contactMessage, string $replyBody)
    {
        $this->contactMessage = $contactMessage;
        $this->replyBody = $replyBody;
    }

    public function build()
    {
        return $this->subject('Reply to your message')
                    ->view('emails.admin_reply')
                    ->with([
                        'name' => $this->contactMessage->name,
                        'original' => $this->contactMessage->message,
                        'reply' => $this->replyBody,
                    ]);
    }
}
