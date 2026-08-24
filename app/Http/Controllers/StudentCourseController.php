<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    /**
     * Liste des cours visibles par l'élève connecté (ou par le parent, pour son enfant).
     */
    public function index(Request $request)
    {
        $student = $this->resolveStudent($request);

        abort_if(! $student, 404, "Aucun élève associé à ce compte.");

        abort_if($student->hasGraduated(), 403,
            "Cet élève a obtenu son baccalauréat et n'a plus accès à la section cours.");

        $courses = Course::query()
            ->where('class_name', $student->current_class)
            ->with('teacher')
            ->orderBy('subject')
            ->get();

        return view('student-courses.index', compact('courses', 'student'));
    }

    /**
     * Détail d'un cours (contenu + ressources) pour l'élève/parent.
     */
    public function show(Request $request, Course $course)
    {
        $student = $this->resolveStudent($request);

        abort_if(! $student, 404, "Aucun élève associé à ce compte.");

        abort_if($student->hasGraduated(), 403,
            "Cet élève a obtenu son baccalauréat et n'a plus accès à la section cours.");

        abort_unless($course->class_name === $student->current_class, 403,
            "Ce cours n'appartient pas à votre classe.");

        $course->load('teacher', 'resources');

        return view('student-courses.show', compact('course', 'student'));
    }

    private function resolveStudent(Request $request)
    {
        $user = $request->user();
        $role = $user->role instanceof \App\Enums\Role ? $user->role->value : $user->role;

        if ($role === 'eleve') {
            return $user->student;
        }

        return $request->filled('student')
            ? $user->children()->find($request->input('student'))
            : $user->children()->first();
    }
}
