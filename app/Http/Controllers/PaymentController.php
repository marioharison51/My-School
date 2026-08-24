<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use App\Notifications\PaymentValidatedNotification;
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
            'amount'     => ['required', 'numeric', 'min:0.01'],
            'method'     => ['required', 'in:mvola,orange_money,airtel_money,virement,especes'],
            'payer_role' => ['required', 'in:eleve,parent'],
            'reference'  => ['nullable', 'string', 'max:255'],
            'paid_at'    => ['required', 'date'],
            'notes'      => ['nullable', 'string'],
        ]);

        $payment = $student->payments()->create([
            ...$validated,
            'recorded_by' => auth()->id(),
        ]);

        $this->applyToInvoiceAndAccounts($student, $payment);
        $this->sendPaymentNotifications($student, $payment, $validated['payer_role']);

        return redirect()
            ->route('payments.index', $student)
            ->with('success', 'Paiement enregistré avec succès.');
    }

    /**
     * Lie le paiement à la facture en attente la plus ancienne, réinitialise
     * le compteur d'impayés, et débloque immédiatement un compte suspendu
     * pour retard de paiement lié à cet élève.
     */
    private function applyToInvoiceAndAccounts(Student $student, Payment $payment): void
    {
        $invoice = $student->invoices()
            ->whereIn('status', ['pending', 'late'])
            ->orderBy('due_date')
            ->first();

        if ($invoice) {
            $invoice->update([
                'status'     => 'paid',
                'payment_id' => $payment->id,
            ]);
        }

        $student->update(['consecutive_missed_payments' => 0]);

        foreach (collect([$student->user, $student->parentUser])->filter() as $account) {
            if ($account->account_status === 'suspended') {
                $account->update([
                    'account_status'  => 'active',
                    'suspended_until' => null,
                    'blocked_reason'  => null,
                ]);
            }
        }
    }

    /**
     * Notifie celui qui a payé instantanément, et l'autre (élève/parent) 1h après.
     */
    private function sendPaymentNotifications(Student $student, Payment $payment, string $payerRole): void
    {
        $payerUser = $payerRole === 'eleve' ? $student->user : $student->parentUser;
        $otherUser = $payerRole === 'eleve' ? $student->parentUser : $student->user;

        if ($payerUser) {
            $payerUser->notify(new PaymentValidatedNotification($payment));
        }

        if ($otherUser) {
            $otherUser->notify((new PaymentValidatedNotification($payment))->delay(now()->addHour()));
        }
    }
}
