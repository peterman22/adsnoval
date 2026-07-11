<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // OTP / email verification on users
        Schema::table('users', function (Blueprint $t) {
            $t->string('otp_code', 10)->nullable()->after('email_verified_at');
            $t->timestamp('otp_expires_at')->nullable()->after('otp_code');
        });

        // Editable email templates (placeholders like {{name}}, {{amount}})
        Schema::create('email_templates', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();     // welcome, otp, transaction
            $t->string('name');
            $t->string('subject');
            $t->text('body');
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('email_templates');
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['otp_code','otp_expires_at']);
        });
    }
};
