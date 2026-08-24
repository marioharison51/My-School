<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\User;
use App\Notifications\AccountPermanentlyBlockedNotification;
use App\Notifications\AccountSuspendedNotification;
use App\Notifications\AccountUnsuspendedNotification;
use App\Notifications\PaymentDueReminder;
use App\Notifications\PaymentOverdueReminder;
use App\Services\Sms\SmsGateway;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ProcessPaymentReminders extends Command
{
    protected $signature = 'payments:process-reminders';
    protected $description = "Envoie les relances de paiement et applique le blocage/déblocage automatique des comptes";

    public function handle(SmsGateway $sms): int
    {
        $today = Carbon::today();

        // 1. Relance avant échéance (J-1)
        $dueTomorrow = Invoice::where('status', 'pending')
            ->whereNull('reminder_before_sent_at')
            ->whereDate('due_date', $today->copy()->addDay())
            ->with('student.parentUser')
            ->get();

        foreach ($dueTomorrow as $invoice) {
            $this->notifyParent(
                $invoice,
                $sms,
                "Rappel : l'écolage de {$invoice->student->full_name} ({$invoice->amount} Ar) est à régler avant le "
                    . $invoice->due_date->format('d/m/Y') . '.',
                PaymentDueReminder::class
            );
            $invoice->update(['reminder_before_sent_at' => now()]);
        }

        // 2. Relance de retard (J+3)
        $lateThreeDays = Invoice::where('status', 'pending')
            ->whereNull('reminder_late_sent_at')
            ->whereDate('due_date', $today->copy()->subDays(3))
            ->with('student.parentUser')
            ->get();

        foreach ($lateThreeDays as $invoice) {
            $invoice->update(['status' => 'late']);
            $this->notifyParent(
                $invoice,
                $sms,
                "Retard de paiement : l'écolage de {$invoice->student->full_name} n'est toujours pas réglé (échéance du "
                    . $invoice->due_date->format('d/m/Y') . '). Merci de régulariser rapidement.',
                PaymentOverdueReminder::class
            );
            $invoice->update(['reminder_late_sent_at' => now()]);
        }

        // 3. Blocage à J+5
        $toBlock = Invoice::whereIn('status', ['pending', 'late'])
            ->whereDate('due_date', $today->copy()->subDays(5))
            ->with('student.user', 'student.parentUser')
            ->get();

        foreach ($toBlock as $invoice) {
            $this->blockForNonPayment($invoice, $sms);
        }

        // 4. Déblocage automatique après 20 jours de suspension
        $toUnblock = User::where('account_status', 'suspended')
            ->whereDate('suspended_until', '<=', $today)
            ->get();

        foreach ($toUnblock as $user) {
            $user->update([
                'account_status'    => 'active',
                'suspended_until'   => null,
                'blocked_reason'    => null,
                'exam_dates_hidden' => true,
            ]);

            $user->notify(new AccountUnsuspendedNotification());

            if ($phone = $this->phoneFor($user)) {
                $sms->send($phone, "Votre compte a été réactivé. Les dates d'examens restent masquées suite au retard de paiement — contactez la direction pour la régularisation complète.");
            }
        }

        return self::SUCCESS;
    }

    private function blockForNonPayment(Invoice $invoice, SmsGateway $sms): void
    {
        $student = $invoice->student;
        $student->increment('consecutive_missed_payments');

        $permanent = $student->consecutive_missed_payments >= 3;

        $accounts = collect([$student->user, $student->parentUser])->filter();

        foreach ($accounts as $account) {
            if ($permanent) {
                $account->update([
                    'account_status'  => 'blocked',
                    'suspended_until' => null,
                    'blocked_reason'  => "Non-paiements répétés (3 échéances consécutives) — contactez l'administrateur pour le déblocage.",
                ]);
                $account->notify(new AccountPermanentlyBlockedNotification());
            } else {
                $account->update([
                    'account_status'  => 'suspended',
                    'suspended_until' => now()->addDays(20),
                    'blocked_reason'  => 'Compte suspendu pour retard de paiement.',
                ]);
                $account->notify(new AccountSuspendedNotification());
            }

            if ($phone = $this->phoneFor($account)) {
                $message = $permanent
                    ? "Compte bloqué suite à des impayés répétés. Veuillez contacter l'administrateur pour le déblocage."
                    : "Compte suspendu pour retard de paiement d'écolage. Merci de régulariser au plus vite.";
                $sms->send($phone, $message);
            }
        }
    }

    private function notifyParent(Invoice $invoice, SmsGateway $sms, string $message, string $notificationClass): void
    {
        $parent = $invoice->student->parentUser;

        if (! $parent) {
            return;
        }

        $parent->notify(new $notificationClass($invoice));

        if ($phone = $invoice->student->parent_phone) {
            $sms->send($phone, $message);
        }
    }

    private function phoneFor(User $user): ?string
    {
        $student = $user->student ?? $user->children()->first();

        return $student?->parent_phone;
    }
}
