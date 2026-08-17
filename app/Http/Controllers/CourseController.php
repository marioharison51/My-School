<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Liste des cours.
     * - admin : voit tous les cours, filtrable par classe et par enseignant
     * - enseignant : ne voit que ses propres cours
     */
    public function index(Request $request)
    {
        $query = Course::query()->with('teacher')->orderBy('class_name')->orderBy('subject');

        if ($request->user()->role === 'enseignant') {
            $query->where('teacher_id', $request->user()->id);
        }

        if ($request->filled('class')) {
            $query->where('class_name', $request->input('class'));
        }

        $courses = $query->paginate(20)->withQueryString();

        $classes = Course::query()
            ->select('class_name')
            ->distinct()
            ->orderBy('class_name')
            ->pluck('class_name');

        return view('courses.index', compact('courses', 'classes'));
    }

    public function create()
    {
        $course = new Course();
        return view('courses.create', compact('course'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateCourse($request);

        // Un enseignant ne peut créer un cours qu'en son propre nom
        if ($request->user()->role === 'enseignant') {
            $validated['teacher_id'] = $request->user()->id;
        }

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('status', 'Cours créé avec succès.');
    }

    public function edit(Course $course)
    {
        $this->authorizeAccess($course);

        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorizeAccess($course);

        $validated = $this->validateCourse($request);

        if ($request->user()->role === 'enseignant') {
            $validated['teacher_id'] = $request->user()->id;
        }

        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('status', 'Cours mis à jour.');
    }

    public function destroy(Course $course)
    {
        $this->authorizeAccess($course);

        $course->delete();

        return redirect()->route('courses.index')
            ->with('status', 'Cours supprimé.');
    }

    /**
     * Empêche un enseignant de modifier/supprimer le cours d'un collègue.
     */
    private function authorizeAccess(Course $course): void
    {
        $user = auth()->user();

        if ($user->role === 'enseignant' && $course->teacher_id !== $user->id) {
            abort(403, "Vous ne pouvez pas modifier le cours d'un autre enseignant.");
        }
    }

    private function validateCourse(Request $request): array
    {
        return $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'subject'     => ['required', 'string', 'max:255'],
            'class_name'  => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);
    }
}
