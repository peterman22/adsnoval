<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycVerification;
use App\Services\Mailer;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KycController extends Controller
{
    public function index()
    {
        $pending = KycVerification::with('user')->where('status', 0)->latest()->get();
        $recent  = KycVerification::with('user')->where('status', '!=', 0)->latest()->limit(25)->get();
        return view('admin.kyc', compact('pending', 'recent'));
    }

    public function approve(KycVerification $verification)
    {
        $verification->update(['status' => 1, 'note' => null, 'reviewed_at' => now()]);
        if ($user = $verification->user) {
            $user->kyc_status = 'approved';
            $user->save();
            $this->notify($user->email, 'Identity verified',
                '<h2 style="color:#fff;margin-top:0">You\'re verified ✅</h2><p>Hi '.e($user->name).', your identity has been approved. You can now watch ads and earn.</p>');
        }
        return back()->with('success', 'Verification approved.');
    }

    public function reject(Request $request, KycVerification $verification)
    {
        $data = $request->validate(['note' => 'required|string|max:300']);
        $verification->update(['status' => 2, 'note' => $data['note'], 'reviewed_at' => now()]);
        if ($user = $verification->user) {
            $user->kyc_status = 'rejected';
            $user->save();
            $this->notify($user->email, 'Verification needs attention',
                '<h2 style="color:#fff;margin-top:0">Verification not approved</h2><p>Hi '.e($user->name).', your identity verification was not approved for the following reason:</p><p style="color:#ffb4b4"><b>'.e($data['note']).'</b></p><p>Please sign in and submit clear documents again.</p>');
        }
        return back()->with('success', 'Verification rejected.');
    }

    /** Stream a private KYC file to the admin ('id' or 'selfie'). */
    public function file(KycVerification $verification, string $which)
    {
        $path = $which === 'selfie' ? $verification->selfie_path : $verification->id_path;
        abort_unless($path && Storage::disk('local')->exists($path), 404);
        return response()->file(Storage::disk('local')->path($path));
    }

    /** Best-effort notification email; never breaks the review action. */
    private function notify(string $to, string $subject, string $html): void
    {
        $site = Setting::val('site_name', config('app.name'));
        try {
            Mailer::sendHtml($to, $site.' — '.$subject, Mailer::wrapHtml($html, $subject));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('KYC email failed: '.$e->getMessage());
        }
    }
}
