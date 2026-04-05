<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'business_profile_id',
    'full_name',
    'phone',
    'email',
    'address',
    'role_type',
    'opening_balance',
    'is_active'
])]
class People extends Model
{
    use HasUuids;

    /**
     * إعدادات تحويل الأنواع (Casting)
     */
    protected function casts(): array
    {
        return [
            'opening_balance' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * العلاقة: هذا الشخص ينتمي لمنشأة تجارية محددة
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(BusinessProfile::class);
    }

    /**
     * العلاقة: إذا كان الشخص عميلاً، فله العديد من طلبات الصيانة
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    /**
     * العلاقة: إذا كان الشخص مورداً، فله العديد من فواتير المشتريات
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'supplier_id');
    }
}
