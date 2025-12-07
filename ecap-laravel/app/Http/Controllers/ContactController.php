<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contactno' => 'nullable|string|max:50',
            'type' => 'required|string|in:feedback,question',
            'message' => 'required|string|max:2000',
        ]);

        // For now, log the message ( MAIL_MAILER=log in .env ).
        // You can later change this to send to a real mailbox or persist to DB.
        $logBody = "Contact form submitted:\nName: {$data['name']}\nEmail: {$data['email']}\nPhone: {$data['contactno']}\nType: {$data['type']}\nMessage:\n{$data['message']}\n";

        // Use the logger to keep a record
        logger()->info($logBody);

        // Optionally: send an email to site admin using the log mailer
        try {
            Mail::raw($logBody, function ($message) use ($data) {
                $message->to(config('mail.from.address'))
                    ->subject('New contact form submission');
            });
        } catch (\Throwable $e) {
            logger()->warning('Mail send failed: '.$e->getMessage());
        }

        return redirect()->route('contact')->with('status', 'Thank you — your message was submitted.');
    }
}
