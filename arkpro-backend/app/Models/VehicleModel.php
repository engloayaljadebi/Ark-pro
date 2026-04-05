<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'brand_id',
    'name'
])]
class VehicleModel extends Model
{
    use HasUuids;

    /**
     * ربط الموديل بجدول مخصص يدوياً
     */
    protected $table = 'models';

    /**
     * إعدادات تحويل الأنواع (Casting) بالأسلوب الحديث
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'brand_id' => 'string', // لأنك تستخدم UUID
        ];
    }

    /**
     * العلاقة: الموديل ينتمي لماركة (Brand) محددة
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * العلاقة: الموديل الواحد قد تندرج تحته عدة أجهزة/عناصر (Items)
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'model_id');
    }
}
