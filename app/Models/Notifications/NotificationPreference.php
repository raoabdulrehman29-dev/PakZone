<?php

namespace App\Models\Notifications;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    use HasFactory;

    protected $table = 'notification_preferences';

    protected $fillable = [
        'user_id',
        'email_enabled',
        'sms_enabled',
        'push_enabled',
        'order_updates',
        'promotional',
        'price_alerts',
        'stock_alerts',
    ];

    protected $casts = [
        'email_enabled' => 'boolean',
        'sms_enabled' => 'boolean',
        'push_enabled' => 'boolean',
        'order_updates' => 'boolean',
        'promotional' => 'boolean',
        'price_alerts' => 'boolean',
        'stock_alerts' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shouldSend($type)
    {
        return $this->{$type} ?? true;
    }

    // Create default preferences for new user
    public static function createDefault($userId)
    {
        return self::create([
            'user_id' => $userId,
            'email_enabled' => true,
            'sms_enabled' => true,
            'push_enabled' => true,
            'order_updates' => true,
            'promotional' => true,
            'price_alerts' => true,
            'stock_alerts' => true,
        ]);
    }
}
