<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycVerification;
use App\Services\Mailer;
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
            Mailer::sendTemplate($user->email, 'kyc_approved', [
                'name' => $user->name, 'login_url' => route('login'),
            ]);
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
            Mailer::sendTemplate($user->email, 'kyc_rejected', [
                'name' => $user->name, 'reason' => $data['note'], 'login_url' => route('login'),
            ]);
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
}
