<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessProfile;
use App\Models\People;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. إنشاء أول منشأة تجارية (المركز الرئيسي)
        $business = BusinessProfile::create([
            'business_name' => 'مركز آرك برو للصيانة',
            'owner_name' => 'المدير العام',
            'primary_phone' => '777000000',
            'password_hash' => Hash::make('password123'),
            'governorate' => 'صنعاء',
            'district' => 'التحرير',
            'street' => 'شارع القصر',
            'is_active' => true,
        ]);

        // 2. إنشاء دور "المدير" إذا لم يكن موجوداً
        $adminRole = Role::firstOrCreate(
            ['name' => 'Manager'],
            ['description' => 'مدير النظام بكامل الصلاحيات']
        );

        // 3. إضافة المدير كشخص (موظف) في جدول people
        $person = People::create([
            'business_profile_id' => $business->id,
            'full_name' => 'أحمد محمد - مدير النظام',
            'phone' => '777000000',
            'role_type' => 'Employee',
            'is_active' => true,
        ]);

        // 4. إنشاء حساب الدخول (User) المرتبط بالشخص والمنشأة
        User::create([
            'business_profile_id' => $business->id,
            'people_id' => $person->id,
            'role_id' => $adminRole->id,
            'username' => 'admin',
            'password' => Hash::make('admin123'), // كلمة المرور الافتراضية
        ]);
    }
}
