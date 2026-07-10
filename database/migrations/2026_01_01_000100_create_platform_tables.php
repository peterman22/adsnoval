<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Core schema for the AdsNoval PTC platform (original build).
 */
return new class extends Migration
{
    public function up(): void
    {
        // Membership plans
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedInteger('daily_limit')->default(10);   // ads/day
            $table->decimal('click_value', 10, 4)->default(0.01);  // per-view payout
            $table->unsignedInteger('validity_days')->default(30);
            $table->unsignedTinyInteger('ref_levels')->default(1);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // PTC advertisements
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();   // null = platform ad
            $table->string('title');
            $table->tinyInteger('type')->default(1);     // 1 url, 2 image, 3 script/html, 4 youtube
            $table->text('body');
            $table->decimal('reward', 10, 4)->default(0.01);
            $table->unsignedInteger('duration')->default(10);   // watch seconds
            $table->unsignedInteger('max_views')->default(100);
            $table->unsignedInteger('views_done')->default(0);
            $table->unsignedInteger('views_left')->default(100);
            $table->tinyInteger('status')->default(1);   // 0 inactive, 1 active, 2 pending
            $table->timestamps();
        });

        // Recorded ad views (earnings)
        Schema::create('ad_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id');
            $table->foreignId('user_id');
            $table->decimal('reward', 10, 4)->default(0);
            $table->date('viewed_on')->index();
            $table->timestamps();
        });

        // Wallet transactions (ledger)
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('trx', 20)->index();
            $table->decimal('amount', 18, 4);
            $table->decimal('post_balance', 18, 4);
            $table->char('type', 1);              // + or -
            $table->string('remark', 40);         // ad_earn, spin, streak, deposit, withdraw, commission...
            $table->string('details')->nullable();
            $table->timestamps();
        });

        // Admin-defined crypto wallets users deposit to (manual)
        Schema::create('crypto_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // e.g. USDT (TRC20)
            $table->string('currency', 20);       // USDT, BTC, ETH...
            $table->string('network')->nullable();// TRC20, ERC20, Bitcoin...
            $table->string('address');            // deposit wallet address
            $table->decimal('rate', 18, 8)->default(1); // 1 unit = X site currency
            $table->decimal('min_amount', 12, 2)->default(5);
            $table->decimal('max_amount', 12, 2)->default(10000);
            $table->string('qr_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Manual crypto deposits
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('crypto_method_id')->nullable();
            $table->string('trx', 20)->index();
            $table->decimal('amount', 18, 4);          // site currency credited
            $table->decimal('sent_amount', 18, 8)->nullable(); // crypto amount user sent
            $table->string('sender_txid')->nullable(); // blockchain tx hash from user
            $table->string('proof_path')->nullable();
            $table->tinyInteger('status')->default(2);  // 2 pending, 1 approved, 3 rejected
            $table->string('admin_note')->nullable();
            $table->timestamps();
        });

        // Withdrawals (manual crypto payout)
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('trx', 20)->index();
            $table->decimal('amount', 18, 4);
            $table->string('currency', 20);
            $table->string('wallet_address');
            $table->tinyInteger('status')->default(2);  // 2 pending, 1 paid, 3 rejected
            $table->string('admin_note')->nullable();
            $table->string('payout_txid')->nullable();
            $table->timestamps();
        });

        // Referral commissions
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id');
            $table->foreignId('to_user_id')->index();
            $table->unsignedTinyInteger('level')->default(1);
            $table->decimal('amount', 18, 4);
            $table->string('remark', 40)->default('ad_commission');
            $table->timestamps();
        });

        // Key/value site settings
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Admins
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['admins','settings','commissions','withdrawals','deposits','crypto_methods','transactions','ad_views','ads','plans'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
