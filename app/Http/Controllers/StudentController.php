<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('nom')->paginate(15);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'classe' => 'required|string|max:100',
            'date_naissance' => 'required|date',
            'tuteur_nom' => 'nullable|string|max:255',
            'tuteur_contact' => 'nullable|string|max:255',
        ]);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Élève ajouté avec succès.');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'classe' => 'required|string|max:100',
            'date_naissance' => 'required|date',
            'tuteur_nom' => 'nullable|string|max:255',
            'tuteur_contact' => 'nullable|string|max:255',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Élève modifié avec succès.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Élève supprimé.');
    }
}