<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Student $student)
    {
        $payments = $student->payments()->latest('paid_at')->get();
        $total = $payments->sum('amount');

        return view('payments.index', compact('student', 'payments', 'total'));
    }

    public function create(Student $student)
    {
        return view('payments.create', compact('student'));
    }

    public function store(Request $request, Student $student)
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'method' => ['required', 'in:mvola,orange_money,airtel_money,virement,especes'],
            'reference' => ['nullable', 'string', 'max:255'],
            'paid_at' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $student->payments()->create([
            ...$validated,
            'recorded_by' => auth()->id(),
        ]);

        return redirect()
            ->route('payments.index', $student)
            ->with('success', 'Paiement enregistré avec succès.');
    }
}