<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Skip 2FA check for certain routes
        $excludedRoutes = [
            'two-factor.show',
            'two-factor.verify',
            'two-factor.resend',
            'logout'
        ];
        
        if (in_array($request->route()->getName(), $excludedRoutes)) {
            return $next($request);
        }
        
        // Check if user needs 2FA verification
        if ($user && $user->needsTwoFactorVerification($request)) {
            // Generate and send code only if no valid code exists
            if (!$user->two_factor_code || 
                !$user->two_factor_expires_at || 
                now()->isAfter($user->two_factor_expires_at)) {
                $code = $user->generateTwoFactorCode();
                try {
                    \Mail::to($user->email)->send(new \App\Mail\TwoFactorCode($user, $code));
                } catch (\Exception $e) {
                    // Log error but continue to 2FA page
                    \Log::error('Failed to send 2FA code: ' . $e->getMessage());
                }
            }
            
            return redirect()->route('two-factor.show');
        }
        
        return $next($request);
    }
}
