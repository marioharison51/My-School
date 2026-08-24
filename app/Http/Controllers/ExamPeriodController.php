<?php

namespace App\Http\Controllers;

use App\Models\ExamPeriod;
use Illuminate\Http\Request;

class ExamPeriodController extends Controller
{
    /**
     * Liste des périodes d'examens + formulaire de création.
     */
    public function index()
    {
        $examPeriods = ExamPeriod::with('activatedBy')
            ->latest('start_date')
            ->get();

        return view('exam-periods.index', compact('examPeriods'));
    }

    /**
     * Création d'une nouvelle période d'examens (inactive par défaut).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'      => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        ExamPeriod::create($validated);

        return redirect()->route('exam-periods.index')
            ->with('status', 'Période d\'examens créée.');
    }

    /**
     * Active ou désactive une période d'examens.
     * Une seule période peut être active à la fois : on désactive les autres.
     */
    public function toggle(Request $request, ExamPeriod $examPeriod)
    {
        if (! $examPeriod->is_active) {
            ExamPeriod::query()->update(['is_active' => false]);

            $examPeriod->update([
                'is_active'    => true,
                'activated_by' => $request->user()->id,
            ]);

            $message = 'Période d\'examens activée : les cours sont désormais masqués pour les élèves et parents.';
        } else {
            $examPeriod->update(['is_active' => false]);
            $message = 'Période d\'examens désactivée : les cours sont de nouveau accessibles.';
        }

        return redirect()->route('exam-periods.index')->with('status', $message);
    }
}
