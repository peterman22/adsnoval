<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{Plan, CryptoMethod, Setting, Admin, Ad, EmailTemplate};
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Plan::insert([
            ['name'=>'Starter','price'=>0,'daily_limit'=>10,'click_value'=>0.01,'validity_days'=>3650,'ref_levels'=>1,'is_popular'=>false,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Pro','price'=>25,'daily_limit'=>50,'click_value'=>0.03,'validity_days'=>30,'ref_levels'=>2,'is_popular'=>true,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Elite','price'=>99,'daily_limit'=>120,'click_value'=>0.05,'validity_days'=>30,'ref_levels'=>3,'is_popular'=>false,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
        ]);

        CryptoMethod::insert([
            ['name'=>'USDT (TRC20)','currency'=>'USDT','network'=>'TRC20','address'=>'TXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX','rate'=>1,'min_amount'=>5,'max_amount'=>10000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Bitcoin','currency'=>'BTC','network'=>'Bitcoin','address'=>'bc1qxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','rate'=>65000,'min_amount'=>10,'max_amount'=>50000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
        ]);

        foreach ([
            ['site_name','AdsNoval'],['currency','USD'],['currency_symbol','$'],
            ['min_withdraw','5'],['withdraw_fee_percent','0'],
            ['spin_free_ad_every','5'],['calc_avg_click','0.05'],
            ['ref_percent_1','10'],['ref_percent_2','3'],['ref_percent_3','1'],
            ['require_email_verification','0'],
            ['mail_host',''],['mail_port','587'],['mail_username',''],['mail_password',''],
            ['mail_encryption','tls'],['mail_from_address','no-reply@adsnoval.com'],['mail_from_name','AdsNoval'],
        ] as [$k,$v]) Setting::updateOrCreate(['key'=>$k],['value'=>$v]);

        // Editable email templates ({{placeholder}} substitution)
        foreach ([
            ['key'=>'welcome','name'=>'Welcome Email','subject'=>'Welcome to {{site_name}}, {{name}}! 🎉',
             'body'=>'<h2 style="color:#fff;margin-top:0">Welcome aboard, {{name}}!</h2><p>Your {{site_name}} account is ready. Start earning today by watching ads, spinning the wheel, and inviting friends.</p><p><b>Username:</b> {{username}}</p><p style="text-align:center;margin-top:24px"><a href="{{login_url}}" style="display:inline-block;padding:12px 26px;border-radius:12px;background:linear-gradient(135deg,#ff9d4d,#ff7a1a);color:#1a1205;font-weight:800;text-decoration:none">Go to my dashboard →</a></p>'],
            ['key'=>'otp','name'=>'OTP / Verification','subject'=>'Your {{site_name}} verification code',
             'body'=>'<h2 style="color:#fff;margin-top:0">Verify your email</h2><p>Use the code below to verify your account. It expires in 10 minutes.</p><p style="text-align:center;font-size:34px;font-weight:800;letter-spacing:8px;color:#ff9d4d;margin:24px 0">{{otp}}</p>'],
            ['key'=>'transaction','name'=>'Transaction Notification','subject'=>'{{site_name}}: {{title}}',
             'body'=>'<h2 style="color:#fff;margin-top:0">{{title}}</h2><p>Hi {{name}}, here are your transaction details:</p><table style="width:100%;border-collapse:collapse"><tr><td style="padding:8px 0;color:#93a0b8">Amount</td><td style="padding:8px 0;text-align:right;font-weight:700">{{amount}}</td></tr><tr><td style="padding:8px 0;color:#93a0b8">Type</td><td style="padding:8px 0;text-align:right">{{type}}</td></tr><tr><td style="padding:8px 0;color:#93a0b8">Balance</td><td style="padding:8px 0;text-align:right">{{balance}}</td></tr><tr><td style="padding:8px 0;color:#93a0b8">Reference</td><td style="padding:8px 0;text-align:right">{{trx}}</td></tr></table>'],
        ] as $t) EmailTemplate::updateOrCreate(['key'=>$t['key']], $t);

        Admin::updateOrCreate(['email'=>'admin@adsnoval.test'],['name'=>'Admin','password'=>Hash::make('password')]);

        // A couple of demo platform ads (user_id null)
        Ad::insert([
            ['title'=>'Discover Wikipedia','type'=>1,'body'=>'https://www.wikipedia.org/','reward'=>0.02,'duration'=>10,'max_views'=>1000,'views_left'=>1000,'status'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Nature in 4K','type'=>4,'body'=>'https://www.youtube.com/embed/ScMzIvxBSi4','reward'=>0.03,'duration'=>15,'max_views'=>1000,'views_left'=>1000,'status'=>1,'created_at'=>now(),'updated_at'=>now()],
        ]);

        // Demo user for testing (login: demo / password)
        \App\Models\User::updateOrCreate(['username'=>'demo'], [
            'name'=>'Demo User','email'=>'demo@adsnoval.test',
            'password'=>Hash::make('password'),'ref_code'=>'DEMO1234','daily_limit'=>10,
            'email_verified_at'=>now(),
        ]);
    }
}
