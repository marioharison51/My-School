<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TardinessRecord;
use Illuminate\Http\Request;

class TardinessController extends Controller
{
    public function index()
    {
        $records = TardinessRecord::with('student', 'recordedBy')
            ->latest('occurred_at')
            ->paginate(20);

        $students = Student::orderBy('last_name')->get();

        return view('tardiness.index', compact('records', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'  => ['required', 'exists:students,id'],
            'occurred_at' => ['required', 'date'],
            'note'        => ['nullable', 'string', 'max:255'],
        ]);

        TardinessRecord::create([
            'student_id'  => $validated['student_id'],
            'recorded_by' => auth()->id(),
            'occurred_at' => $validated['occurred_at'],
            'note'        => $validated['note'] ?? null,
        ]);

        return redirect()
            ->route('tardiness.index')
            ->with('success', 'Retard enregistré.');
    }
}
