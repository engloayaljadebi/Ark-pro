<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

#[Fillable([
    'business_profile_id', // الربط مع المنشأة
    'people_id',           // الربط مع سجل البيانات الشخصية (الموظف)
    'username',
    'password',
    'role_id',
    'last_login'
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * إعدادات تحويل البيانات (Casting) بالأسلوب الحديث
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'last_login' => 'datetime',
            'email_verified_at' => 'datetime', // في حال أردت تفعيل التحقق من الإيميل لاحقاً
        ];
    }

    /**
     * العلاقة مع المنشأة التجارية (Business Profile)
     */
    public function business(): BelongsTo
    {
        // تم استخدام business_profile_id ليتوافق مع تسمية الجدول لديك
        return $this->belongsTo(BusinessProfile::class, 'business_profile_id');
    }

    /**
     * العلاقة مع سجل البيانات الشخصية (الموظف)
     * ملاحظة: تم دمج تسمية 'person' و 'profile' لتكون 'person' لأنها تعبر عن جدول People
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(People::class, 'people_id');
    }

    /**
     * العلاقة مع الصلاحية (Role)
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * دالة مساعدة للتحقق مما إذا كان المستخدم يمتلك دوراً معيناً
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role->name === $roleName;
    }
}
