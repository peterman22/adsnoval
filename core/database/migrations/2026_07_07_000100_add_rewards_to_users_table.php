<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds daily-streak and spin-the-wheel tracking to users. All additive and
 * nullable so it is safe to run against an existing populated table.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'streak_count')) {
                $table->unsignedInteger('streak_count')->default(0)->after('balance');
            }
            if (!Schema::hasColumn('users', 'last_check_in')) {
                $table->date('last_check_in')->nullable()->after('streak_count');
            }
            if (!Schema::hasColumn('users', 'last_spin_at')) {
                $table->date('last_spin_at')->nullable()->after('last_check_in');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['streak_count', 'last_check_in', 'last_spin_at'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
