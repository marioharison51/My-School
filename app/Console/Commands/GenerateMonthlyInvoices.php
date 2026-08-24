<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GenerateMonthlyInvoices extends Command
{
    protected $signature = 'invoices:generate-monthly';
    protected $description = "Génère les factures d'écolage du mois pour les élèves ayant un montant défini";

    public function handle(): int
    {
        $periodMonth = Carbon::now()->startOfMonth();
        $dueDate = Carbon::now()->startOfMonth()->day(10);

        $students = Student::query()->whereHas('fee')->with('fee')->get();

        $created = 0;

        foreach ($students as $student) {
            $exists = Invoice::where('student_id', $student->id)
                ->where('period_month', $periodMonth->toDateString())
                ->exists();

            if ($exists) {
                continue;
            }

            Invoice::create([
                'student_id'   => $student->id,
                'period_month' => $periodMonth,
                'due_date'     => $dueDate,
                'amount'       => $student->fee->monthly_amount,
                'status'       => 'pending',
            ]);

            $created++;
        }

        $this->info("{$created} facture(s) générée(s) pour {$periodMonth->format('m/Y')}.");

        return self::SUCCESS;
    }
}
