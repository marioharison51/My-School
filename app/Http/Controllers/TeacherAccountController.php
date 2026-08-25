<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Services\AccountBlockingService;
use Illuminate\Http\Request;

class TeacherAccountController extends Controller
{
    private const REASONS = [
        'comportement' => 'Blocage suite à un comportement inapproprié.',
        'absences'     => 'Blocage suite à 2 absences.',
        'retards'      => 'Blocage suite à 3 retards successifs.',
    ];

    public function __construct(private AccountBlockingService $blocking)
    {
    }

    public function block(Request $request, Student $student)
    {
        $validated = $request->validate(['reason' => ['required', 'in:' . implode(',', array_keys(self::REASONS))]]);

        abort_unless($student->user, 404, "Cet élève n'a pas encore de compte utilisateur.");

        $this->blocking->block($student->user, self::REASONS[$validated['reason']]);

        return back()->with('status', 'Compte élève bloqué.');
    }

    /**
     * Déblocage temporaire : l'élève retrouve l'accès de base mais doit passer
     * par l'admin/direction pour réinitialiser son mot de passe et retrouver
     * l'accès complet aux fonctionnalités.
     */
    public function unblockTemporary(Student $student)
    {
        abort_unless($student->user, 404, "Cet élève n'a pas encore de compte utilisateur.");

        $this->blocking->unblockTemporarily($student->user);

        return back()->with('status', "Compte débloqué temporairement. L'élève doit se rapprocher de la direction pour retrouver l'accès complet.");
    }
}
