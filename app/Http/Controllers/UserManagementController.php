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

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Rôle de {$user->name} mis à jour.");
    }
}
