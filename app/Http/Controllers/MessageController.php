<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $received = Message::with('sender')
            ->where('recipient_id', auth()->id())
            ->latest()
            ->get();

        return view('messages.index', compact('received'));
    }

    public function create()
    {
        $recipients = User::where('id', '!=', auth()->id())->orderBy('name')->get();

        return view('messages.create', compact('recipients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => ['required', 'exists:users,id'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        Message::create([
            ...$validated,
            'sender_id' => auth()->id(),
        ]);

        return redirect()
            ->route('messages.index')
            ->with('success', 'Message envoyé.');
    }

    public function show(Message $message)
    {
        abort_unless($message->recipient_id === auth()->id() || $message->sender_id === auth()->id(), 403);

        if ($message->recipient_id === auth()->id() && ! $message->read_at) {
            $message->update(['read_at' => now()]);
        }

        return view('messages.show', compact('message'));
    }
}
