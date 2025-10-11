<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportHistory extends Model
{
    protected $fillable = [
        'user_id', 'type', 'input_data', 'result_data', 'payment_reference', 'paid_at'
    ];

    protected $casts = [
        'input_data' => 'array',
        'result_data' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
