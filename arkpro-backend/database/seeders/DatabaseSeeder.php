<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessProfile;
use App\Models\People;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. إنشاء المنشأة (البيئة الأساسية)
        $business = BusinessProfile::create([
            'business_name' => 'مركز آرك برو التقني',
            'owner_name' => 'المدير العام',
            'primary_phone' => '777111222',
            'password_hash' => Hash::make('password'),
            'governorate' => 'صنعاء',
            'district' => 'السبعين',
            'street' => 'شارع حدة',
        ]);

        // 2. إنشاء الصلاحية
        $managerRole = Role::create([
            'name' => 'Manager',
            'description' => 'مدير النظام بكامل الصلاحيات'
        ]);

        // 3. إنشاء الشخص (الموظف)
        $person = People::create([
            'business_profile_id' => $business->id,
            'full_name' => 'أحمد محمد الحيمي',
            'phone' => '777111222',
            'role_type' => 'Employee',
            'is_active' => true,
        ]);

        // 4. إنشاء مستخدم الإدمن (حساب الدخول)
        User::create([
            'business_profile_id' => $business->id,
            'people_id' => $person->id,
            'role_id' => $managerRole->id,
            'username' => 'admin',
            'password' => Hash::make('admin123'), // كلمة المرور
        ]);

        $this->command->info('تم إنشاء مستخدم الإدمن بنجاح: user: admin | pass: admin123');
    }
}
