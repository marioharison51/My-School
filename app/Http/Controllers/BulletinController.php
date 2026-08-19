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
     * moyenne par matière + moyenne générale + rang dans la classe.
     */
    public function show(Request $request, Student $student)
    {
        $term = $request->query('term');

        $bySubject = $this->subjectAveragesFor($student, $term);

        $generalAverage = $bySubject->isNotEmpty()
            ? round($bySubject->pluck('average')->avg(), 2)
            : null;

        // Calcul du rang parmi les élèves de la même classe
        $classmates = Student::where('current_class', $student->current_class)->get();

        $rankings = $classmates
            ->map(function ($classmate) use ($term) {
                $average = $this->subjectAveragesFor($classmate, $term)->pluck('average');

                return [
                    'student_id' => $classmate->id,
                    'average' => $average->isNotEmpty() ? round($average->avg(), 2) : null,
                ];
            })
            ->filter(fn ($row) => $row['average'] !== null)
            ->sortByDesc('average')
            ->values();

        $rankIndex = $rankings->search(fn ($row) => $row['student_id'] === $student->id);
        $rank = $rankIndex === false ? null : $rankIndex + 1;
        $totalRanked = $rankings->count();

        return view('bulletins.show', [
            'student' => $student,
            'term' => $term,
            'bySubject' => $bySubject,
            'generalAverage' => $generalAverage,
            'rank' => $rank,
            'totalRanked' => $totalRanked,
        ]);
    }

    /**
     * Calcule la moyenne par matière (ramenée sur 20) pour un élève et un trimestre donnés.
     */
    private function subjectAveragesFor(Student $student, ?string $term)
    {
        $grades = Grade::query()
            ->with('exam.course')
            ->where('student_id', $student->id)
            ->whereHas('exam', function ($q) use ($term) {
                if ($term) {
                    $q->where('term', $term);
                }
            })
            ->get();

        return $grades
            ->groupBy(fn ($grade) => $grade->exam->course->subject)
            ->map(function ($subjectGrades) {
                $normalized = $subjectGrades->map(function ($grade) {
                    return ($grade->score / $grade->exam->max_score) * 20;
                });

                return [
                    'grades' => $subjectGrades,
                    'average' => round($normalized->avg(), 2),
                ];
            });
    }
}
