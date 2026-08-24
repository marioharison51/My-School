<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentFee;
use Illuminate\Http\Request;

class StudentFeeController extends Controller
{
    /**
     * Formulaire pour définir/modifier le montant mensuel d'écolage.
     */
    public function edit(Student $student)
    {
        $fee = $student->fee;

        return view('student-fees.edit', compact('student', 'fee'));
    }

    /**
     * Enregistre un nouveau montant (on garde l'historique via un nouvel enregistrement).
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'monthly_amount' => ['required', 'numeric', 'min:0'],
        ]);

        StudentFee::create([
            'student_id'     => $student->id,
            'monthly_amount' => $validated['monthly_amount'],
            'set_by'         => $request->user()->id,
        ]);

        return redirect()->route('students.show', $student)
            ->with('status', "Montant d'écolage mis à jour.");
    }
}
