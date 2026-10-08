<?php
use Illuminate\Database\Migrations\Migration;
use App\Models\EmailTemplate;

return new class extends Migration {
    public function up(): void {
        foreach ([
            ['key'=>'kyc_approved','name'=>'KYC Approved','subject'=>'Your {{site_name}} identity is verified ✅',
             'body'=>'<h2 style="color:#fff;margin-top:0">You\'re verified, {{name}}!</h2><p>Your identity has been approved. You can now watch ads and earn on {{site_name}}.</p><p style="text-align:center;margin-top:24px"><a href="{{login_url}}" style="display:inline-block;padding:12px 26px;border-radius:12px;background:linear-gradient(135deg,#ff9d4d,#ff7a1a);color:#1a1205;font-weight:800;text-decoration:none">Start earning →</a></p>'],
            ['key'=>'kyc_rejected','name'=>'KYC Rejected','subject'=>'{{site_name}}: your verification needs attention',
             'body'=>'<h2 style="color:#fff;margin-top:0">Verification not approved</h2><p>Hi {{name}}, your identity verification was not approved for the following reason:</p><p style="color:#ffb4b4;font-weight:700">{{reason}}</p><p>Please sign in and submit clear documents again.</p><p style="text-align:center;margin-top:24px"><a href="{{login_url}}" style="display:inline-block;padding:12px 26px;border-radius:12px;background:linear-gradient(135deg,#ff9d4d,#ff7a1a);color:#1a1205;font-weight:800;text-decoration:none">Re-submit documents →</a></p>'],
        ] as $t) {
            EmailTemplate::firstOrCreate(['key'=>$t['key']], $t);
        }
    }

    public function down(): void {
        EmailTemplate::whereIn('key', ['kyc_approved','kyc_rejected'])->delete();
    }
};
