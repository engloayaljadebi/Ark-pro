<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('business_profiles', function (Blueprint $table) {
            // المعرف الفريد للنشاط التجاري
            $table->uuid('id')->primary();

            // المعلومات الأساسية
            $table->string('business_name')->index(); // اسم المحل/الشركة
            $table->string('owner_name');             // اسم المالك
            $table->string('primary_phone')->unique(); // رقم التواصل الأساسي
            $table->string('secondary_phone')->nullable();
            $table->string('password_hash');          // كلمة المرور المشفرة للدخول للوحة التحكم

            // الموقع الجغرافي (اليمن - المحافظات والمديريات)
            $table->string('governorate')->comment('المحافظة');
            $table->string('district')->comment('المديرية');
            $table->text('street')->nullable()->comment('الشارع أو الحي');
            $table->text('map_location_url')->nullable(); // رابط خرائط جوجل

            // إعدادات المظهر والاشتراك
            $table->string('logo_url')->nullable();   // رابط الشعار
            $table->boolean('is_public')->default(true); // هل النشاط ظاهر للعامة؟
            $table->boolean('is_active')->default(true); // هل الحساب مفعل؟

            // إعدادات النظام
            $table->string('subscription_plan')->default('free'); // نوع الاشتراك (مجاني/برو)
            $table->string('currency_code')->default('YER');      // العملة الافتراضية (ريال يمني)
            $table->json('settings')->nullable()->comment('إعدادات الهوية ورسائل الواتساب');

            // التوقيت (created_at & updated_at)
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_profiles');
    }
};
