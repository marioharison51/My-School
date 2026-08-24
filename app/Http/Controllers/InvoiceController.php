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
}
