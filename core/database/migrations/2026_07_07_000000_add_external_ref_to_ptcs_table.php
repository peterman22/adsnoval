<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds an idempotency key so ads pulled from an external source can be
 * matched on subsequent syncs (update instead of duplicate insert).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ptcs', function (Blueprint $table) {
            if (!Schema::hasColumn('ptcs', 'external_ref')) {
                $table->string('external_ref')->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('ptcs', 'source')) {
                // e.g. "mock", "adsterra". Null = created by an advertiser/admin.
                $table->string('source')->nullable()->after('external_ref');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ptcs', function (Blueprint $table) {
            if (Schema::hasColumn('ptcs', 'external_ref')) {
                $table->dropUnique(['external_ref']);
                $table->dropColumn('external_ref');
            }
            if (Schema::hasColumn('ptcs', 'source')) {
                $table->dropColumn('source');
            }
        });
    }
};
