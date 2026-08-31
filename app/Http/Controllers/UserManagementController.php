<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'in:' . implode(',', array_column(Role::cases(), 'value'))],
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Compte {$validated['name']} créé avec succès.");
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
