<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('subject');
            $table->string('class_name');
            $table->text('description')->nullable();

            // Enseignant qui a créé / donne le cours.
            // Nullable : si le compte enseignant est supprimé, le cours reste
            // (un autre enseignant peut le reprendre) au lieu de disparaître.
            $table->foreignId('teacher_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
