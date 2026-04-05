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
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('business_id')->constrained('business_profiles')->onDelete('cascade');
            $table->foreignUuid('brand_id')->constrained('brands')->onDelete('cascade');

            $table->string('name'); // اسم القطعة (مثلاً: شاشة آيفون X وكالة)
            $table->string('sku_code')->unique(); // كود القطعة أو الباركود
            $table->string('unit')->default('piece'); // الوحدة (حبة، متر، إلخ)

            // الحسابات المالية للقطعة
            $table->decimal('cost_price', 15, 2);    // التكلفة (مثلاً 8000)
            $table->decimal('selling_price', 15, 2); // سعر البيع (مثلاً 10000)

            // المخزون
            $table->integer('current_stock')->default(0); // الكمية المتوفرة حالياً
            $table->integer('alert_qty')->default(5);     // التنبيه عند وصول الكمية لهذا الرقم

            $table->integer('warranty_days')->default(0); // مدة الضمان بالأيام
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
