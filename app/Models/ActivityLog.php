<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'model_name',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Get the user who performed the action
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an activity
     */
    public static function log($action, $model, $oldValues = null, $newValues = null)
    {
        // For updates, create separate log entries for each changed field
        if ($action === 'updated' && $oldValues && $newValues) {
            foreach ($newValues as $field => $newValue) {
                $oldValue = $oldValues[$field] ?? null;
                
                // Only log if the value actually changed
                // Use loose comparison for null checks, strict for others
                if ($oldValue !== $newValue) {
                    self::create([
                        'user_id' => auth()->id(),
                        'action' => $action,
                        'model_type' => class_basename($model),
                        'model_id' => $model->id,
                        'model_name' => $model->name ?? null,
                        'old_values' => [$field => $oldValue],
                        'new_values' => [$field => $newValue],
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ]);
                }
            }
        } else {
            // For other actions (created, archived, etc.), create a single entry
            return self::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'model_type' => class_basename($model),
                'model_id' => $model->id,
                'model_name' => $model->name ?? null,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }

    /**
     * Get action badge color
     */
    public function getActionColorAttribute()
    {
        return match($this->action) {
            'created' => 'green',
            'updated' => 'blue',
            'archived' => 'gray',
            'unarchived' => 'green',
            'activated' => 'green',
            'deactivated' => 'yellow',
            default => 'gray',
        };
    }

    /**
     * Get action icon
     */
    public function getActionIconAttribute()
    {
        return match($this->action) {
            'created' => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
            'updated' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
            'archived' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M10 12v4m4-4v4',
            'unarchived' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
            'activated' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'deactivated' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636',
            default => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        };
    }
}
