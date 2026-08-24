<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('account_status', ['active', 'suspended', 'blocked'])
                  ->default('active')
                  ->after('password');
            $table->date('suspended_until')->nullable()->after('account_status');
            $table->string('blocked_reason')->nullable()->after('suspended_until');
            $table->boolean('exam_dates_hidden')->default(false)->after('blocked_reason');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['account_status', 'suspended_until', 'blocked_reason', 'exam_dates_hidden']);
        });
    }
};
