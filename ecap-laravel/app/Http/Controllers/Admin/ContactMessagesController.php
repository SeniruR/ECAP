<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminReplyToContact;

class ContactMessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(25);
        return view('admin.contacts.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        if (! $contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        return view('admin.contacts.show', ['message' => $contactMessage]);
    }

    public function reply(Request $request, ContactMessage $contactMessage)
    {
        $request->validate([
            'reply_body' => ['required','string','max:8000'],
        ]);

        Mail::to($contactMessage->email)->send(new AdminReplyToContact($contactMessage, $request->input('reply_body')));

        $contactMessage->update([
            'is_replied' => true,
            'replied_at' => now(),
            'reply_body' => $request->input('reply_body'),
        ]);

        return redirect()->route('admin.contacts.show', $contactMessage)->with('success','Reply sent.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contacts.index')->with('success','Message deleted.');
    }
}
