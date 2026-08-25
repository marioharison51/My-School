<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', 'in:administrateur,enseignant,eleve,parent,comptable'],
        ]);

        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', "Vous ne pouvez pas modifier votre propre rôle.");
        }

        $isLastAdmin = $user->role === 'administrateur'
            && $validated['role'] !== 'administrateur'
            && User::where('role', 'administrateur')->count() <= 1;

        if ($isLastAdmin) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', "Impossible de retirer le rôle administrateur : c'est le dernier compte administrateur du système.");
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Rôle de {$user->name} mis à jour.");
    }
}
