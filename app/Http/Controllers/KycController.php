<?php
namespace App\Http\Controllers;

use App\Models\KycVerification;
use Illuminate\Http\Request;

class KycController extends Controller
{
    public function index()
    {
        $user   = auth()->user();
        $latest = $user->kycVerifications()->first();
        return view('kyc.index', compact('user', 'latest'));
    }

    public function submit(Request $request)
    {
        $user = auth()->user();

        if ($user->kyc_status === 'approved') {
            return back()->with('error', 'Your identity is already verified.');
        }
        if ($user->kyc_status === 'pending') {
            return back()->with('error', 'Your verification is already under review.');
        }

        $data = $request->validate([
            'doc_type'    => 'required|in:passport,national_id,drivers_license',
            'id_document' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:8192',
            'selfie'      => 'required|file|mimes:jpg,jpeg,png,webp|max:8192',
        ]);

        // Stored on the private 'local' disk (storage/app) — never web-accessible.
        $idPath     = $request->file('id_document')->store('kyc/'.$user->id, 'local');
        $selfiePath = $request->file('selfie')->store('kyc/'.$user->id, 'local');

        KycVerification::create([
            'user_id'     => $user->id,
            'doc_type'    => $data['doc_type'],
            'id_path'     => $idPath,
            'selfie_path' => $selfiePath,
            'status'      => 0,
        ]);

        $user->kyc_status = 'pending';
        $user->save();

        return back()->with('success', 'Your documents were submitted. We will review your verification shortly.');
    }
}
