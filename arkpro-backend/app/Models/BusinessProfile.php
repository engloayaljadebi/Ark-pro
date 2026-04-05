<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'business_name',
    'owner_name',
    'primary_phone',
    'secondary_phone',
    'password_hash',
    'governorate',
    'district',
    'street',
    'map_location_url',
    'logo_url',
    'is_public',
    'is_active',
    'subscription_plan',
    'currency_code',
    'settings'
])]
#[Hidden(['password_hash'])]
class BusinessProfile extends Model
{
    use HasUuids;

    /**
     * إعدادات تحويل الأنواع (Casting) بالأسلوب الحديث
     */
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'is_active' => 'boolean',
            'settings' => 'json',
            'password_hash' => 'hashed',
        ];
    }

    /** * العلاقات (Relationships)
     */

    // الأشخاص المرتبطين بالمنشأة (عملاء، موردين، الخ)
    public function people(): HasMany
    {
        return $this->hasMany(People::class);
    }

    // المستخدمين (الموظفين) الذين لديهم صلاحية دخول للمنشأة
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // طلبات الصيانة أو المبيعات التابعة للمنشأة
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // الأصناف أو الأجهزة المسجلة في المنشأة
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    // صور المنشأة (مثل صور المحل أو اللوحة)
    public function photos(): HasMany
    {
        return $this->hasMany(BusinessPhoto::class);
    }
}
