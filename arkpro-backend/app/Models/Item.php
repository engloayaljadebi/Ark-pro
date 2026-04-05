<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'business_id', 'brand_id', 'name', 'sku_code',
    'unit', 'cost_price', 'selling_price', 'current_stock',
    'alert_qty', 'warranty_days'
])]
class Item extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'cost_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
            'current_stock' => 'integer',
        ];
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(BusinessProfile::class);
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
