<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['business_id', 'staff_id', 'amount_paid', 'payment_method', 'payout_date', 'notes'])]
class SalaryPayout extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'amount_paid' => 'decimal:2',
            'payout_date' => 'datetime',
        ];
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(People::class, 'staff_id');
    }
}
