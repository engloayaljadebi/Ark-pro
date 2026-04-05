<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'business_id', 'staff_id', 'order_id', 'transaction_type',
    'revenue_amount', 'cost_amount', 'net_profit_amount', 'commission_earned', 'notes'
])]
class StaffLedger extends Model
{
    use HasUuids;

    protected $table = 'staff_ledger'; // لأن الاسم في الهجرة مفرد

    protected function casts(): array
    {
        return [
            'revenue_amount' => 'decimal:2',
            'cost_amount' => 'decimal:2',
            'net_profit_amount' => 'decimal:2',
            'commission_earned' => 'decimal:2',
        ];
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(People::class, 'staff_id');
    }
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
