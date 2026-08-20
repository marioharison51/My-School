<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentReceiptController extends Controller
{
    public function show(Student $student, Payment $payment)
    {
        abort_unless($payment->student_id === $student->id, 404);

        $pdf = Pdf::loadView('payments.receipt', compact('student', 'payment'));

        return $pdf->stream("recu-{$payment->id}.pdf");
    }
}
