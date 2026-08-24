<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->date('period_month');  // premier jour du mois concerné
            $table->date('due_date');      // toujours le 10 du mois
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending', 'paid', 'late'])->default('pending');
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('reminder_before_sent_at')->nullable();
            $table->timestamp('reminder_late_sent_at')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'period_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
