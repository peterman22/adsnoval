<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Earning / wallet
            $table->decimal('balance', 18, 4)->default(0);
            $table->unsignedInteger('daily_limit')->default(10);

            // Membership
            $table->foreignId('plan_id')->nullable();
            $table->timestamp('plan_expires_at')->nullable();

            // Referrals
            $table->string('ref_code', 16)->unique();
            $table->foreignId('referred_by')->nullable()->index();

            // Rewards
            $table->unsignedInteger('streak_count')->default(0);
            $table->date('last_check_in')->nullable();
            $table->date('last_spin_at')->nullable();
            $table->unsignedInteger('spin_count')->default(0);
            $table->unsignedInteger('free_ad_credits')->default(0);

            $table->boolean('is_banned')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
