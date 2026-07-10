<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{Plan, CryptoMethod, Setting, Admin, Ad};
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
        ] as [$k,$v]) Setting::updateOrCreate(['key'=>$k],['value'=>$v]);

        Admin::updateOrCreate(['email'=>'admin@adsnoval.test'],['name'=>'Admin','password'=>Hash::make('password')]);

        // A couple of demo platform ads (user_id null)
        Ad::insert([
            ['title'=>'Discover Wikipedia','type'=>1,'body'=>'https://www.wikipedia.org/','reward'=>0.02,'duration'=>10,'max_views'=>1000,'views_left'=>1000,'status'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Nature in 4K','type'=>4,'body'=>'https://www.youtube.com/embed/ScMzIvxBSi4','reward'=>0.03,'duration'=>15,'max_views'=>1000,'views_left'=>1000,'status'=>1,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
