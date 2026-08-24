<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Services\AccountBlockingService;
use Illuminate\Http\Request;

class AdminAccountController extends Controller
{
    public function __construct(private AccountBlockingService $blocking) {}

    private const PARENT_REASONS = [
        'enfant_quitte'   => "L'enfant a quitté l'établissement.",
        'enfant_renvoye'  => "L'enfant a été renvoyé.",
        'autre'           => 'Blocage administratif.',
    ];

    private const STUDENT_REASONS = [
        'absences'      => 'Blocage suite à 3 absences répétées.',
        'retards'       => 'Blocage suite à 5 retards successifs.',
        'sanction'      => 'Blocage suite à une sanction disciplinaire.',
        'obstruction'   => 'Blocage suite à obstruction/manquement au règlement.',
        'comportement'  => 'Blocage suite à un comportement inapproprié.',
        'autre'         => 'Blocage administratif.',
    ];

    public function blockParent(Request $request, User $user)
    {
        $validated = $request->validate(['reason' => ['required', 'in:' . implode(',', array_keys(self::PARENT_REASONS))]]);

        $this->blocking->block($user, self::PARENT_REASONS[$validated['reason']]);

        return back()->with('status', 'Compte parent bloqué.');
    }

    public function blockStudent(Request $request, User $user)
    {
        $validated = $request->validate(['reason' => ['required', 'in:' . implode(',', array_keys(self::STUDENT_REASONS))]]);

        $this->blocking->block($user, self::STUDENT_REASONS[$validated['reason']]);

        return back()->with('status', 'Compte élève bloqué.');
    }

    /**
     * Déblocage pour toute raison SAUF retard/non-paiement (réservé au comptable).
     */
    public function unblock(User $user)
    {
        abort_if(
            $user->blocked_reason && str_contains($user->blocked_reason, 'paiement'),
            403,
            "Ce compte est bloqué pour un motif de paiement — le déblocage doit passer par le comptable."
        );

        $this->blocking->unblockWithPasswordReset($user);

        return back()->with('status', 'Compte débloqué, mot de passe réinitialisé.');
    }

    /**
     * Suppression de compte suite à un renvoi (soft delete : conservé en base pour historique).
     */
    public function destroy(Student $student)
    {
        $student->user?->delete();
        $student->parentUser?->delete();

        return redirect()->route('students.index')->with('status', 'Comptes supprimés suite au renvoi.');
    }
}
