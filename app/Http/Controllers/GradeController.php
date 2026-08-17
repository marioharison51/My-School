<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Formulaire de saisie des notes pour tous les élèves de la classe
     * concernée par cet examen.
     */
    public function edit(Request $request, Exam $exam)
    {
        $this->assertAccess($request, $exam);

        $students = Student::query()
            ->where('current_class', $exam->course->class_name)
            ->orderBy('last_name')
            ->get();

        // Notes déjà saisies, indexées par student_id
        $existingGrades = Grade::query()
            ->where('exam_id', $exam->id)
            ->get()
            ->keyBy('student_id');

        return view('grades.edit', compact('exam', 'students', 'existingGrades'));
    }

    /**
     * Enregistre les notes de tous les élèves en une seule soumission.
     * Attend un tableau : scores[student_id] = note, comments[student_id] = commentaire
     */
    public function update(Request $request, Exam $exam)
    {
        $this->assertAccess($request, $exam);

        $validated = $request->validate([
            'scores'            => ['required', 'array'],
            'scores.*'          => ['nullable', 'numeric', 'min:0', 'max:' . $exam->max_score],
            'comments'          => ['nullable', 'array'],
            'comments.*'        => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($validated['scores'] as $studentId => $score) {
            if ($score === null || $score === '') {
                continue;
            }

            Grade::updateOrCreate(
                ['exam_id' => $exam->id, 'student_id' => $studentId],
                [
                    'score'   => $score,
                    'comment' => $validated['comments'][$studentId] ?? null,
                ]
            );
        }

        return redirect()->route('exams.index')
            ->with('status', 'Notes enregistrées avec succès.');
    }

    private function assertAccess(Request $request, Exam $exam): void
    {
        if ($request->user()->role === 'enseignant'
            && $exam->course->teacher_id !== $request->user()->id) {
            abort(403, "Vous ne pouvez pas saisir les notes d'un examen qui n'est pas le vôtre.");
        }
    }
}
