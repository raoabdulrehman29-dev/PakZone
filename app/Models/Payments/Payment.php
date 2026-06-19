<?php

namespace App\Models\Payments;

use App\Models\Auth\User;
use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'method',
        'status',
        'transaction_id',
        'payment_data',
        'refunded_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_data' => 'array',
        'refunded_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function markAsCompleted($transactionId = null)
    {
        $this->status = 'completed';
        if ($transactionId) {
            $this->transaction_id = $transactionId;
        }
        $this->save();
    }

    public function markAsFailed()
    {
        $this->status = 'failed';
        $this->save();
    }

    public function markAsRefunded()
    {
        $this->status = 'refunded';
        $this->refunded_at = now();
        $this->save();
    }
}
