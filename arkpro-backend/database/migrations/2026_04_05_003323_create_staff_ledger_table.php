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
        Schema::create('staff_ledger', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('business_id')->constrained('business_profiles');

            // الموظف المستحق (أحمد)
            $table->foreignUuid('staff_id')->constrained('people');
            // طلب الصيانة المرتبط
            $table->foreignUuid('order_id')->constrained('orders');

            // نوع العملية (Commission: عمولة، Salary: راتب، Bonus: مكافأة)
            $table->string('transaction_type')->default('Commission');

            // تفاصيل الحسبة المالية (تطبيق مثالك بدقة)
            $table->decimal('revenue_amount', 15, 2);    // الإيراد (10000)
            $table->decimal('cost_amount', 15, 2);       // التكلفة (8000)
            $table->decimal('net_profit_amount', 15, 2); // الربح الصافي (2000)
            $table->decimal('commission_earned', 15, 2); // العمولة المستحقة لأحمد (1000)

            $table->text('notes')->nullable(); // "عمولة إصلاح شاشة جهاز رقم..."
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_ledger');
    }
};
