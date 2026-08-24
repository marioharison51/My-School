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
        $user = $request->user();
        $role = $user->role instanceof \App\Enums\Role ? $user->role->value : $user->role;

        if ($role === 'eleve') {
            $student = $user->student;
        } else {
            // Parent : on prend le premier enfant par défaut, ou celui passé en paramètre
            $student = $request->filled('student')
                ? $user->children()->findOrFail($request->input('student'))
                : $user->children()->first();
        }

        abort_if(! $student, 404, "Aucun élève associé à ce compte.");

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
        $user = $request->user();
        $role = $user->role instanceof \App\Enums\Role ? $user->role->value : $user->role;

        if ($role === 'eleve') {
            $student = $user->student;
        } else {
            $student = $request->filled('student')
                ? $user->children()->findOrFail($request->input('student'))
                : $user->children()->first();
        }

        abort_if(! $student, 404, "Aucun élève associé à ce compte.");

        // Un élève/parent ne peut voir que les cours de sa propre classe
        abort_unless($course->class_name === $student->current_class, 403,
            "Ce cours n'appartient pas à votre classe.");

        $course->load('teacher', 'resources');

        return view('student-courses.show', compact('course', 'student'));
    }
}
