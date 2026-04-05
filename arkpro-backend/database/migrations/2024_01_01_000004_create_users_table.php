<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BusinessProfile;
use App\Models\People;
use App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // الربط بالمنشأة (النشاط التجاري)
            $table->foreignIdFor(BusinessProfile::class)
                ->constrained()
                ->cascadeOnDelete();

            // الربط ببيانات الشخص (الموظف) من جدول people
            $table->foreignIdFor(People::class)
                ->constrained()
                ->cascadeOnDelete();

            // بيانات الدخول (استخدمنا username بدلاً من email بناءً على طلبك السابق)
            $table->string('username')->unique();
            $table->string('password');

            // الربط بالصلاحيات
            // $table->foreignIdFor(Role::class)->constrained();
            // --- التعديل هنا لضمان التوافق مع UUID ---
            $table->foreignUuid('role_id')
                ->constrained('roles')
                ->cascadeOnDelete();


            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // جدول استعادة كلمة المرور (احتفظنا به مع تعديل بسيط)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('username')->primary(); // البحث باسم المستخدم
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // جدول الجلسات (Sessions) - قمنا بتعديل user_id ليدعم UUID
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignUuid('user_id')->nullable()->index(); // تعديل لـ foreignUuid
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
