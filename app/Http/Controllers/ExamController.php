<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Liste des examens.
     * - admin : voit tous les examens
     * - enseignant : ne voit que les examens de ses propres cours
     */
    public function index(Request $request)
    {
        $query = Exam::query()->with('course.teacher')->orderBy('exam_date', 'desc');

        if ($request->user()->role === 'enseignant') {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('teacher_id', $request->user()->id);
            });
        }

        $exams = $query->paginate(20);

        return view('exams.index', compact('exams'));
    }

    public function create(Request $request)
    {
        $exam = new Exam();
        $courses = $this->availableCourses($request);

        return view('exams.create', compact('exam', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateExam($request);

        $this->assertCourseAccess($request, $validated['course_id']);

        Exam::create($validated);

        return redirect()->route('exams.index')
            ->with('status', 'Examen planifié avec succès.');
    }

    public function edit(Request $request, Exam $exam)
    {
        $this->assertCourseAccess($request, $exam->course_id);

        $courses = $this->availableCourses($request);

        return view('exams.edit', compact('exam', 'courses'));
    }

    public function update(Request $request, Exam $exam)
    {
        $this->assertCourseAccess($request, $exam->course_id);

        $validated = $this->validateExam($request);

        $this->assertCourseAccess($request, $validated['course_id']);

        $exam->update($validated);

        return redirect()->route('exams.index')
            ->with('status', 'Examen mis à jour.');
    }

    public function destroy(Request $request, Exam $exam)
    {
        $this->assertCourseAccess($request, $exam->course_id);

        $exam->delete();

        return redirect()->route('exams.index')
            ->with('status', 'Examen supprimé.');
    }

    /**
     * Cours disponibles pour la création d'un examen :
     * - admin : tous les cours
     * - enseignant : uniquement ses propres cours
     */
    private function availableCourses(Request $request)
    {
        $query = Course::query()->orderBy('class_name')->orderBy('subject');

        if ($request->user()->role === 'enseignant') {
            $query->where('teacher_id', $request->user()->id);
        }

        return $query->get();
    }

    /**
     * Empêche un enseignant de planifier/modifier un examen sur le cours d'un collègue.
     */
    private function assertCourseAccess(Request $request, int $courseId): void
    {
        if ($request->user()->role !== 'enseignant') {
            return;
        }

        $course = Course::findOrFail($courseId);

        if ($course->teacher_id !== $request->user()->id) {
            abort(403, "Vous ne pouvez pas gérer les examens du cours d'un autre enseignant.");
        }
    }

    private function validateExam(Request $request): array
    {
        return $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'title'     => ['required', 'string', 'max:255'],
            'term'      => ['required', 'string', 'max:100'],
            'exam_date' => ['required', 'date'],
            'max_score' => ['required', 'integer', 'min:1', 'max:100'],
        ]);
    }
}
