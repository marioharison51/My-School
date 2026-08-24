<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_periods', function (Blueprint $table) {
            $table->id();

            $table->string('label')->nullable();      // ex: "Examens Trimestre 1"
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(false);

            // Qui a activé la période (traçabilité)
            $table->foreignId('activated_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_periods');
    }
};
