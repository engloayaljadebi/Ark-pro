<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['business_id', 'category', 'amount', 'notes', 'expense_date'])]
class Expense extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'expense_date' => 'date',
        ];
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(BusinessProfile::class);
    }
}
