<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'type', 'title', 'description', 'url', 'icon', 'color', 'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    public static function notifyAdmins(string $type, string $title, string $description, string $url, string $icon = 'bell', string $color = 'blue', ?int $excludeUserId = null, bool $deduplicateDaily = false): void
    {
        User::where('role', 'admin')
            ->when($excludeUserId, fn($q) => $q->where('id', '!=', $excludeUserId))
            ->each(function ($admin) use ($type, $title, $description, $url, $icon, $color, $deduplicateDaily) {
                if ($deduplicateDaily) {
                    $exists = static::where('user_id', $admin->id)
                        ->where('type', $type)
                        ->where('title', $title)
                        ->whereDate('created_at', today())
                        ->exists();

                    if ($exists) return;
                }

                static::create([
                    'user_id'     => $admin->id,
                    'type'        => $type,
                    'title'       => $title,
                    'description' => $description,
                    'url'         => $url,
                    'icon'        => $icon,
                    'color'       => $color,
                ]);
            });
    }
}
