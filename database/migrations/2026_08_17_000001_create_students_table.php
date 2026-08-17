<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // Identité
            $table->string('last_name');
            $table->string('first_name');
            $table->date('birth_date');
            $table->string('birth_place');

            // Parents
            $table->string('father_name')->nullable();
            $table->string('father_job')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_job')->nullable();
            $table->string('parent_phone');           // obligatoire
            $table->string('parent_email')->nullable(); // facultatif

            // Adresse
            $table->string('address');

            // Scolarité antérieure
            $table->string('previous_school')->nullable();
            $table->string('previous_class')->nullable();

            // Scolarité actuelle
            $table->string('current_class');

            // Projet
            $table->string('desired_career')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
