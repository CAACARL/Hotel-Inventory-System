<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department',
        'is_active',
        'profile_picture',
        'two_factor_enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'two_factor_enabled' => 'boolean',
            'two_factor_expires_at' => 'datetime',
            'two_factor_verified_at' => 'datetime',
        ];
    }
    
    /**
     * Get the transactions for the user.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
    /**
     * Get the trusted devices for the user.
     */
    public function trustedDevices()
    {
        return $this->hasMany(TrustedDevice::class);
    }
    
    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    /**
     * Check if user is staff.
     */
    public function isStaff()
    {
        return $this->role === 'staff';
    }
    
    /**
     * Get the profile picture URL.
     */
    public function getProfilePictureUrl()
    {
        if ($this->profile_picture && file_exists(public_path('storage/' . $this->profile_picture))) {
            return asset('storage/' . $this->profile_picture);
        }
        
        return null;
    }
    
    /**
     * Get profile picture or default avatar.
     */
    public function getAvatarUrl()
    {
        return $this->getProfilePictureUrl() ?: $this->getDefaultAvatar();
    }
    
    /**
     * Get default avatar based on user initials.
     */
    public function getDefaultAvatar()
    {
        $initials = strtoupper(substr($this->name, 0, 1));
        if (strpos($this->name, ' ') !== false) {
            $nameParts = explode(' ', $this->name);
            $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
        }
        
        // Generate a color based on the user's name
        $colors = ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-purple-500', 'bg-pink-500', 'bg-indigo-500'];
        $colorIndex = ord($this->name[0]) % count($colors);
        
        return [
            'initials' => $initials,
            'color' => $colors[$colorIndex]
        ];
    }
    
    /**
     * Generate a new two-factor authentication code.
     */
    public function generateTwoFactorCode()
    {
        $this->two_factor_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->two_factor_verified_at = null;
        $this->save();
        
        return $this->two_factor_code;
    }
    
    /**
     * Verify the two-factor authentication code.
     */
    public function verifyTwoFactorCode($code)
    {
        if (!$this->two_factor_code || !$this->two_factor_expires_at) {
            return false;
        }
        
        if (now()->isAfter($this->two_factor_expires_at)) {
            return false;
        }
        
        if ($this->two_factor_code !== $code) {
            return false;
        }
        
        $this->two_factor_verified_at = now();
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
        
        return true;
    }
    
    /**
     * Check if user needs two-factor verification.
     */
    public function needsTwoFactorVerification($request = null)
    {
        if (!$this->two_factor_enabled) {
            return false;
        }
        
        // If no request provided (for backward compatibility), require 2FA
        if (!$request) {
            return true;
        }
        
        // Generate device fingerprint
        $deviceFingerprint = TrustedDevice::generateFingerprint($request);
        
        // Check if this device is trusted
        $trustedDevice = $this->trustedDevices()
            ->where('device_fingerprint', $deviceFingerprint)
            ->first();
            
        if ($trustedDevice) {
            // Update last used timestamp
            $trustedDevice->update([
                'last_used_at' => now(),
                'ip_address' => $request->ip(),
            ]);
            return false;
        }
        
        // Device not trusted, require 2FA
        return true;
    }
    
    /**
     * Mark current device as trusted after successful 2FA
     */
    public function trustCurrentDevice($request)
    {
        $deviceFingerprint = TrustedDevice::generateFingerprint($request);
        $userAgent = $request->header('User-Agent', '');
        
        // Create or update trusted device
        $this->trustedDevices()->updateOrCreate(
            ['device_fingerprint' => $deviceFingerprint],
            [
                'device_name' => TrustedDevice::getDeviceName($userAgent),
                'user_agent' => $userAgent,
                'ip_address' => $request->ip(),
                'last_used_at' => now(),
            ]
        );
    }
}