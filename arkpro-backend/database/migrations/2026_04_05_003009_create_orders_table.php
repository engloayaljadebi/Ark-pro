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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_number')->unique(); // رقم الكرت/الفاتورة

            $table->foreignUuid('business_id')->constrained('business_profiles');
            $table->foreignUuid('customer_id')->constrained('people'); // العميل
            $table->foreignUuid('creator_id')->constrained('users');   // الموظف الذي استلم الجهاز
            $table->foreignUuid('technician_id')->nullable()->constrained('users'); // الفني المكلّف

            $table->foreignUuid('model_id')->nullable()->constrained('models');
            $table->foreignUuid('type_id')->constrained('order_types');
            $table->foreignUuid('status_id')->constrained('order_statuses');

            // بيانات الجهاز
            $table->string('imei_serial')->nullable();
            $table->string('device_password')->nullable();
            $table->text('issue_description'); // وصف المشكلة من العميل
            $table->text('technical_diagnosis')->nullable(); // تشخيص الفني

            // المبالغ المالية المتفق عليها
            $table->decimal('agreed_price', 15, 2);    // السعر الكلي المتفق عليه (مثلاً 10000)
            $table->decimal('prepaid_amount', 15, 2)->default(0); // العربون
            $table->decimal('discount_amount', 15, 2)->default(0);

            // التواريخ
            $table->timestamp('estimated_delivery')->nullable(); // الموعد المتوقع للتسليم
            $table->timestamp('actual_delivery')->nullable();    // تاريخ التسليم الفعلي
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
