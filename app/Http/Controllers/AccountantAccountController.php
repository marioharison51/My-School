<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AccountBlockingService;
use Illuminate\Http\Request;

class AccountantAccountController extends Controller
{
    public function __construct(private AccountBlockingService $blocking)
    {
    }

    public function block(Request $request, User $user)
    {
        $this->blocking->block($user, 'Blocage manuel pour non-paiement / retard de paiement.');

        return back()->with('status', 'Compte bloqué pour retard/non-paiement.');
    }

    public function unblockAfterMissedPayments(User $user)
    {
        $this->blocking->unblockWithPasswordReset($user);

        return back()->with('status', 'Compte débloqué suite à régularisation (3 non-paiements), mot de passe réinitialisé.');
    }

    public function unblockAfterLatePayment(User $user)
    {
        $this->blocking->unblockWithPasswordReset($user);

        return back()->with('status', 'Compte débloqué suite à régularisation du retard, mot de passe réinitialisé.');
    }
}
