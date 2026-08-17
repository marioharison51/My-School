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

            $table->string('title');          // Nom du cours
            $table->string('subject');        // Matière
            $table->string('class_name');     // Classe à laquelle le cours est attribué
            $table->text('description')->nullable();

            // Enseignant qui a créé / donne le cours
            $table->foreignId('teacher_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
