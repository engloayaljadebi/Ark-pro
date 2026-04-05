<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['business_id', 'name', 'logo_path'])]
class Brand extends Model
{
    use HasUuids;

    public function business(): BelongsTo
    {
        return $this->belongsTo(BusinessProfile::class);
    }

    public function models(): HasMany
    {
        return $this->hasMany(DeviceModel::class, 'brand_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
