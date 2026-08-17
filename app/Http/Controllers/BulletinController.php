<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class BulletinController extends Controller
{
    /**
     * Choix de l'élève et du trimestre pour générer le bulletin.
     */
    public function select(Request $request)
    {
        $students = Student::orderBy('current_class')->orderBy('last_name')->get();

        $terms = Grade::query()
            ->join('exams', 'grades.exam_id', '=', 'exams.id')
            ->select('exams.term')
            ->distinct()
            ->pluck('term');

        return view('bulletins.select', compact('students', 'terms'));
    }

    /**
     * Affiche le bulletin d'un élève pour un trimestre donné :
     * moyenne par matière + moyenne générale.
     */
    public function show(Request $request, Student $student)
    {
        $term = $request->query('term');

        $grades = Grade::query()
            ->with('exam.course')
            ->where('student_id', $student->id)
            ->whereHas('exam', function ($q) use ($term) {
                if ($term) {
                    $q->where('term', $term);
                }
            })
            ->get();

        // Regroupement par matière avec calcul de moyenne (note ramenée sur 20)
        $bySubject = $grades->groupBy(fn ($grade) => $grade->exam->course->subject)
            ->map(function ($subjectGrades) {
                $normalized = $subjectGrades->map(function ($grade) {
                    return ($grade->score / $grade->exam->max_score) * 20;
                });

                return [
                    'grades'  => $subjectGrades,
                    'average' => round($normalized->avg(), 2),
                ];
            });

        $generalAverage = $bySubject->isNotEmpty()
            ? round($bySubject->avg('average'), 2)
            : null;

        return view('bulletins.show', [
            'student'        => $student,
            'term'           => $term,
            'bySubject'      => $bySubject,
            'generalAverage' => $generalAverage,
        ]);
    }
}
