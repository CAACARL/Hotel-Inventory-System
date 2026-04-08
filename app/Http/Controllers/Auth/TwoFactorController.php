<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCode;

class TwoFactorController extends Controller
{
    /**
     * Show the two-factor verification form.
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->two_factor_enabled || !$user->needsTwoFactorVerification($request)) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.two-factor');
    }
    
    /**
     * Send a new two-factor code.
     */
    public function resend()
    {
        $user = Auth::user();
        
        if (!$user->two_factor_enabled) {
            return redirect()->route('dashboard');
        }
        
        $code = $user->generateTwoFactorCode();
        
        try {
            Mail::to($user->email)->send(new TwoFactorCode($user, $code));
            return back()->with('success', 'A new verification code has been sent to your email.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send verification code. Please try again.');
        }
    }
    
    /**
     * Verify the two-factor code.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);
        
        $user = Auth::user();
        
        if ($user->verifyTwoFactorCode($request->code)) {
            // Trust this device after successful verification
            $user->trustCurrentDevice($request);
            
            return redirect()->intended(route('dashboard'))->with('success', 'Two-factor authentication verified successfully!');
        }
        
        return back()->withErrors(['code' => 'Invalid or expired verification code.']);
    }
    
    /**
     * Enable two-factor authentication.
     */
    public function enable()
    {
        $user = Auth::user();
        $user->two_factor_enabled = true;
        $user->save();
        
        $code = $user->generateTwoFactorCode();
        
        try {
            Mail::to($user->email)->send(new TwoFactorCode($user, $code));
            return redirect()->route('two-factor.show')->with('success', 'Two-factor authentication enabled! Check your email for the verification code.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send verification code. Please try again.');
        }
    }
    
    /**
     * Disable two-factor authentication.
     */
    public function disable()
    {
        $user = Auth::user();
        $user->two_factor_enabled = false;
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->two_factor_verified_at = null;
        $user->save();
        
        return back()->with('success', 'Two-factor authentication has been disabled.');
    }
}
