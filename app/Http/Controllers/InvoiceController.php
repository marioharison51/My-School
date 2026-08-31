<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Student;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Liste globale des factures (filtrable par statut).
     */
    public function index(Request $request)
    {
        $query = Invoice::with('student')->orderBy('due_date', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $invoices = $query->paginate(30)->withQueryString();

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Factures d'un élève donné.
     */
    public function forStudent(Student $student)
    {
        $invoices = $student->invoices()->orderBy('due_date', 'desc')->get();

        return view('invoices.student', compact('student', 'invoices'));
    }

    /**
     * Vue élèves en lecture seule pour le comptable — statut de paiement uniquement,
     * pas d'accès au CRUD élèves (réservé à administrateur/enseignant).
     */
    public function students(Request $request)
    {
        $query = Student::query()
            ->whereNull('graduated_at')
            ->withCount([
                'invoices as late_invoices_count' => fn ($q) => $q->where('status', 'late'),
                'invoices as pending_invoices_count' => fn ($q) => $q->where('status', 'pending'),
            ])
            ->orderByDesc('consecutive_missed_payments')
            ->orderBy('last_name');

        if ($request->input('status') === 'late') {
            $query->where(fn ($q) => $q
                ->where('consecutive_missed_payments', '>', 0)
                ->orWhereHas('invoices', fn ($q2) => $q2->where('status', 'late')));
        } elseif ($request->input('status') === 'pending') {
            $query->whereHas('invoices', fn ($q2) => $q2->where('status', 'pending'));
        }

        $students = $query->paginate(30)->withQueryString();

        return view('invoices.students', compact('students'));
    }
}
