<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tracks total spins (to gate the "1 Free Ad" prize) and a consumable
 * free-ad-credit balance that tops up a user's daily ad-view allowance.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'spin_count')) {
                $table->unsignedInteger('spin_count')->default(0)->after('last_spin_at');
            }
            if (!Schema::hasColumn('users', 'free_ad_credits')) {
                $table->unsignedInteger('free_ad_credits')->default(0)->after('spin_count');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['spin_count', 'free_ad_credits'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
