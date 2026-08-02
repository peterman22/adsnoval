<?php
namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class EnsureKycVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (Setting::val('require_kyc', '1') === '1'
            && optional($request->user())->kyc_status !== 'approved') {
            return redirect()->route('kyc.index')
                ->with('error', 'Please verify your identity before watching ads.');
        }
        return $next($request);
    }
}
