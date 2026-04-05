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
        Schema::create('ticket_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // ربط القطعة بطلب الصيانة
            $table->foreignUuid('order_id')->constrained('orders')->onDelete('cascade');
            // ربط القطعة بجدول الأصناف (المخزن)
            $table->foreignUuid('item_id')->constrained('items');

            $table->integer('qty')->default(1); // الكمية المستخدمة
            $table->decimal('price_at_sale', 15, 2); // سعر البيع وقت العملية (الـ 10000 في مثالك)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_items');
    }
};
