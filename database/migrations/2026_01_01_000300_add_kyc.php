<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kyc_verifications', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('doc_type')->nullable();          // passport, national_id, drivers_license
            $t->string('id_path');                        // stored on the private 'local' disk
            $t->string('selfie_path');
            $t->unsignedTinyInteger('status')->default(0); // 0 pending, 1 approved, 2 rejected
            $t->string('note')->nullable();               // rejection reason
            $t->timestamp('reviewed_at')->nullable();
            $t->timestamps();
        });

        Schema::table('users', function (Blueprint $t) {
            // unverified | pending | approved | rejected
            $t->string('kyc_status', 20)->default('unverified')->after('email_verified_at');
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn('kyc_status');
        });
        Schema::dropIfExists('kyc_verifications');
    }
};
