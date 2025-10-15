<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarValuationReport extends Model
{
    protected $fillable = [
        'user_id',
        'make',
        'reference',
        'model',
        'year',
        'trim',
        'vin',
        'min_value',
        'max_value',
        'average_value',
        'additional_data',
        'payment_status',
        'payment_reference',
        'payment_data',
        'paid_at',
    ];

    protected $casts = [
        'year' => 'integer',
        'min_value' => 'decimal:2',
        'max_value' => 'decimal:2',
        'average_value' => 'decimal:2',
        'additional_data' => 'array',
        'payment_data' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'completed' && $this->paid_at !== null;
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'completed')->whereNotNull('paid_at');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('F j, Y');
    }
}