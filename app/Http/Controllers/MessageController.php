<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Matrice des rôles que chaque rôle est autorisé à contacter.
     */
    private const ALLOWED_RECIPIENTS = [
        'administrateur' => ['enseignant', 'parent', 'eleve', 'comptable'],
        'enseignant' => ['administrateur', 'parent', 'eleve'],
        'eleve' => ['administrateur', 'enseignant'],
        'parent' => ['administrateur', 'enseignant'],
        'comptable' => ['administrateur', 'parent'],
    ];

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
        $allowedRoles = self::ALLOWED_RECIPIENTS[auth()->user()->role] ?? [];

        $recipients = User::whereIn('role', $allowedRoles)
            ->orderBy('name')
            ->get();

        return view('messages.create', compact('recipients'));
    }

    public function store(Request $request)
    {
        $allowedRoles = self::ALLOWED_RECIPIENTS[auth()->user()->role] ?? [];

        $validated = $request->validate([
            'recipient_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) use ($allowedRoles) {
                    $recipient = User::find($value);
                    if (! $recipient || ! in_array($recipient->role, $allowedRoles, true)) {
                        $fail("Vous n'êtes pas autorisé à contacter ce destinataire.");
                    }
                },
            ],
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
