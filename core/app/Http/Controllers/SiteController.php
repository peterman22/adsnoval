<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\GatewayCurrency;
use App\Models\Language;
use App\Models\Page;
use App\Models\Plan;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class SiteController extends Controller
{
    /**
     * Public "proof of payment" feed for the live ticker. Depending on config
     * (config/withdraw_feed.php) it returns real approved withdrawals,
     * simulated social-proof entries, or a blend of both.
     */
    public function withdrawFeed()
    {
        $cfg   = config('withdraw_feed');
        $mode  = $cfg['mode'] ?? 'generated';
        $count = (int) ($cfg['count'] ?? 15);

        $feed = collect();

        if ($mode === 'real' || $mode === 'mixed') {
            $feed = Withdrawal::approved()
                ->with('user:id,username')
                ->orderByDesc('updated_at')
                ->limit($count)
                ->get()
                ->map(fn ($w) => [
                    'user'   => $this->maskUsername(optional($w->user)->username ?? 'user'),
                    'amount' => showAmount($w->amount),
                    'method' => $w->method_currency ?? '',
                    'ago'    => $w->updated_at ? $w->updated_at->diffForHumans() : '',
                ]);
        }

        if ($mode === 'generated' || $mode === 'mixed') {
            $feed = $feed->concat($this->generatedFeed($cfg, $count))->take($count);
        }

        return response()->json([
            'status' => 'success',
            'total'  => showAmount($this->feedTotalPaid($cfg)),
            'count'  => $feed->count(),
            'feed'   => $feed->values(),
        ]);
    }

    /**
     * Build simulated payout entries. Each slot is seeded by its interval
     * "bucket" so the list is stable between polls and advances by exactly one
     * new entry every `interval_minutes`.
     */
    protected function generatedFeed(array $cfg, int $count): \Illuminate\Support\Collection
    {
        $interval = max(1, (int) ($cfg['interval_minutes'] ?? 5)) * 60;
        $min      = (float) ($cfg['min_amount'] ?? 53);
        $max      = (float) ($cfg['max_amount'] ?? 7305);
        $skew     = (float) ($cfg['skew'] ?? 2.4);
        $names    = $cfg['names'] ?? ['user'];
        $methods  = $cfg['methods'] ?? ['USDT'];

        $now  = time();
        $feed = collect();

        for ($i = 0; $i < $count; $i++) {
            $bucketStart = $now - ($i * $interval);
            $seed        = intdiv($bucketStart, $interval);
            mt_srand($seed);

            $name    = $names[mt_rand(0, count($names) - 1)] . mt_rand(2, 99);
            $method  = $methods[mt_rand(0, count($methods) - 1)];
            $r       = mt_rand(0, 100000) / 100000;           // 0..1
            $amount  = $min + ($max - $min) * pow($r, $skew);  // skewed low
            $offset  = mt_rand(0, $interval - 1);              // within-window jitter

            $feed->push([
                'user'   => $this->maskUsername($name),
                'amount' => showAmount(round($amount, 2)),
                'method' => $method,
                'ago'    => \Carbon\Carbon::createFromTimestamp($bucketStart - $offset)->diffForHumans(),
            ]);
        }

        mt_srand(); // restore randomness
        return $feed;
    }

    /** A believable, steadily-growing "total paid out" headline number. */
    protected function feedTotalPaid(array $cfg): float
    {
        if (($cfg['mode'] ?? 'generated') === 'real') {
            return (float) Withdrawal::approved()->sum('amount');
        }
        $base   = (float) ($cfg['total_base'] ?? 0);
        $perDay = (float) ($cfg['total_per_day'] ?? 0);
        $anchor = Carbon::parse($cfg['total_anchor_date'] ?? '2025-01-01');
        $days   = max(0, $anchor->diffInDays(Carbon::now()));
        // Add a smooth intraday portion so it ticks up through the day.
        $intraday = $perDay * (Carbon::now()->secondsSinceMidnight() / 86400);
        return $base + ($days * $perDay) + $intraday;
    }

    /** Turn "peterman22" into "p******22" for privacy. */
    protected function maskUsername(string $name): string
    {
        $len = strlen($name);
        if ($len <= 3) {
            return substr($name, 0, 1) . str_repeat('*', 2);
        }
        return substr($name, 0, 1) . str_repeat('*', max(3, $len - 3)) . substr($name, -2);
    }

    public function index()
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname', activeTemplate())->where('slug', '/')->first();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;

        // Data for the public earnings calculator
        $calcPlans = Plan::where('status', 1)->orderBy('price')->get(['name', 'price', 'daily_limit', 'validity']);
        $calcConfig = config('rewards.calculator');

        return view('Template::home', compact('pageTitle', 'sections', 'seoContents', 'seoImage', 'calcPlans', 'calcConfig'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', activeTemplate())->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        $seoContents = $page->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::pages', compact('pageTitle', 'sections', 'seoContents', 'seoImage'));
    }


    public function plans()
    {
        $pageTitle       = 'Plans';
        $plans           = Plan::where('status', 1)->get();
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('name')->get();
        $sections = Page::where('tempname', activeTemplate())->where('slug', 'plans')->first();
        return view('Template::plans', compact('pageTitle', 'plans', 'sections', 'gatewayCurrency'));
    }



    public function contact()
    {
        $pageTitle = "Contact Us";
        $user = auth()->user();
        $sections = Page::where('tempname', activeTemplate())->where('slug', 'contact')->first();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::contact', compact('pageTitle', 'user', 'sections', 'seoContents', 'seoImage'));
    }


    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        $request->session()->regenerateToken();

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new contact message has been submitted';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug)
    {
        $policy = Frontend::where('slug', $slug)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        $seoContents = $policy->seo_content;
        $seoImage = @$seoContents->image ? frontendImage('policy_pages', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::policy', compact('policy', 'pageTitle', 'seoContents', 'seoImage'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blog()
    {
        $pageTitle = 'Blog';
        $sections  = Page::where('tempname', activeTemplate())->where('slug', 'blog')->firstOrFail();
        $blogs     = Frontend::where('data_keys', 'blog.element')->where('tempname', activeTemplateName())->orderBy('id', 'desc')->paginate(getPaginate(12));

        $seoContents = @$sections->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::blog.blogs', compact('pageTitle', 'sections', 'blogs','seoContents','seoImage'));
    }


    public function blogDetails($slug)
    {
        $blog        = Frontend::where('slug', $slug)->where('data_keys', 'blog.element')->firstOrFail();
        $latests     = Frontend::where('data_keys', 'blog.element')->where('tempname', activeTemplateName())->where('id', '!=', $blog->id)->orderBy('id', 'desc')->limit(5)->get();
        $popular     = Frontend::where('data_keys', 'blog.element')->where('tempname', activeTemplateName())->where('id', '!=', $blog->id)->orderBy('view', 'desc')->limit(5)->get();
        $pageTitle   = $blog->data_values->title;
        $seoContents = $blog->seo_content;
        $seoImage    = @$seoContents->image ? frontendImage('blog', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::blog.details', compact('blog', 'pageTitle', 'seoContents', 'seoImage', 'latests', 'popular',));
    }


    public function cookieAccept()
    {
        Cookie::queue('gdpr_cookie', gs('site_name'), 43200);
    }

    public function cookiePolicy()
    {
        $cookieContent = Frontend::where('data_keys', 'cookie.data')->first();
        abort_if($cookieContent->data_values->status != Status::ENABLE, 404);
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view('Template::cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font/solaimanLipi_bold.ttf');
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        if (gs('maintenance_mode') == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view('Template::maintenance', compact('pageTitle', 'maintenance'));
    }
}
