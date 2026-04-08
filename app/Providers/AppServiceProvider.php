<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Item;
use App\Models\Batch;
use App\Models\BorrowedItem;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('layouts.partials.header', function ($view) {
            if (!Auth::check()) return;

            // For admins: sync once-per-day passive alerts (expiring/expired batches)
            if (Auth::user()->isAdmin()) {
                $this->syncPassiveAdminAlerts();
            } else {
                $this->syncStaffBorrowedNotifications(Auth::user());
            }

            $notifications = Notification::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->limit(30)
                ->get();

            $unreadCount = $notifications->whereNull('read_at')->count();

            $view->with(compact('notifications', 'unreadCount'));
        });
    }

    /**
     * Once-per-day passive alerts for admins: expiring & expired batches only.
     * Low stock is triggered at point-of-action (borrow/return/disposal).
     */
    private function syncPassiveAdminAlerts(): void
    {
        // Expiring soon (within 30 days)
        Batch::where('status', 'active')
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '>', now())
            ->where('expiry_date', '<=', now()->addDays(30))
            ->with('item')
            ->each(function ($batch) {
                Notification::notifyAdmins(
                    'expiring',
                    'Expiring Soon: ' . $batch->item->name,
                    'Batch ' . $batch->batch_number . ' expires ' . $batch->expiry_date->diffForHumans(),
                    route('batches.show', $batch),
                    'clock', 'orange', null, true
                );
            });

        // Expired batches still marked active
        Batch::where('status', 'active')
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<', now())
            ->with('item')
            ->each(function ($batch) {
                Notification::notifyAdmins(
                    'expired',
                    'Expired Batch: ' . $batch->item->name,
                    'Batch ' . $batch->batch_number . ' expired ' . $batch->expiry_date->diffForHumans(),
                    route('batches.show', $batch),
                    'x', 'red', null, true
                );
            });
    }

    /**
     * Sync staff notifications for their currently borrowed items (once per day).
     */
    private function syncStaffBorrowedNotifications($user): void
    {
        BorrowedItem::where('user_id', $user->id)
            ->with('item')
            ->each(function ($borrowed) use ($user) {
                $exists = Notification::where('user_id', $user->id)
                    ->where('type', 'borrowed_item')
                    ->where('title', 'You have borrowed: ' . $borrowed->item->name)
                    ->whereDate('created_at', today())
                    ->exists();

                if (!$exists) {
                    Notification::create([
                        'user_id'     => $user->id,
                        'type'        => 'borrowed_item',
                        'title'       => 'You have borrowed: ' . $borrowed->item->name,
                        'description' => $borrowed->quantity . ' ' . $borrowed->item->unit . ' — since ' . $borrowed->borrowed_at->diffForHumans(),
                        'url'         => route('items.index'),
                        'icon'        => 'borrow',
                        'color'       => 'blue',
                    ]);
                }
            });
    }
}
