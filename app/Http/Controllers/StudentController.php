<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Liste des élèves, avec filtre optionnel par classe (?class=...)
     */
    public function index(Request $request)
    {
        $query = Student::query()->orderBy('current_class')->orderBy('last_name');

        if ($request->filled('class')) {
            $query->where('current_class', $request->input('class'));
        }

        $students = $query->paginate(20)->withQueryString();

        // Liste distincte des classes existantes, pour le filtre dans la vue
        $classes = Student::query()
            ->select('current_class')
            ->distinct()
            ->orderBy('current_class')
            ->pluck('current_class');

        return view('students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $student = new Student();
        return view('students.create', compact('student'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateStudent($request);

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('status', 'Élève inscrit avec succès.');
    }

    public function show(Student $student)
    {
        $student->load(['user', 'parentUser', 'fee']);

        $recentPayments = $student->payments()->latest('paid_at')->limit(5)->get();
        $recentInvoices = $student->invoices()->orderBy('due_date', 'desc')->limit(6)->get();

        return view('students.show', compact('student', 'recentPayments', 'recentInvoices'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $this->validateStudent($request);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('status', 'Fiche élève mise à jour.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('status', 'Élève supprimé.');
    }

    private function validateStudent(Request $request): array
    {
        return $request->validate([
            'last_name'        => ['required', 'string', 'max:255'],
            'first_name'       => ['required', 'string', 'max:255'],
            'birth_date'       => ['required', 'date'],
            'birth_place'      => ['required', 'string', 'max:255'],
            'father_name'      => ['nullable', 'string', 'max:255'],
            'father_job'       => ['nullable', 'string', 'max:255'],
            'mother_name'      => ['nullable', 'string', 'max:255'],
            'mother_job'       => ['nullable', 'string', 'max:255'],
            'parent_phone'     => ['required', 'string', 'max:30'],
            'parent_email'     => ['nullable', 'email', 'max:255'],
            'address'          => ['required', 'string', 'max:500'],
            'previous_school'  => ['nullable', 'string', 'max:255'],
            'previous_class'   => ['nullable', 'string', 'max:100'],
            'current_class'    => ['required', 'string', 'max:100'],
            'desired_career'   => ['nullable', 'string', 'max:255'],
        ]);
    }
}
