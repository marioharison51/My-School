<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Génère les factures d'écolage le 1er de chaque mois à 00h05
Schedule::command('invoices:generate-monthly')
    ->monthlyOn(1, '00:05');

// Traite les relances, blocages et déblocages tous les jours à 07h00
Schedule::command('payments:process-reminders')
    ->dailyAt('07:00');
