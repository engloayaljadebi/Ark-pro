<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BusinessProfile;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // ربط الشخص بالمحل (النشاط التجاري)
            $table->foreignUuid('business_id')->constrained('business_profiles')->onDelete('cascade');

            // البيانات الشخصية
            $table->string('full_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            // تصنيف الشخص (Customer, Supplier, Employee)
            $table->string('role_type')->index();

            // بيانات الموظفين (للحسابات المالية والعمولات)
            $table->decimal('base_salary', 15, 2)->default(0)->comment('الراتب الثابت');
            $table->decimal('commission_rate', 5, 2)->default(0)->comment('نسبة الموظف من الربح، مثل 0.50 للـ 50%');

            // الحساب المالي (المحفظة)
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
