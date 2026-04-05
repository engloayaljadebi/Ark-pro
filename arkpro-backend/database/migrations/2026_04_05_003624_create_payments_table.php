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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('business_id')->constrained('business_profiles');
            $table->foreignUuid('order_id')->constrained('orders')->onDelete('cascade');

            $table->decimal('amount', 15, 2); // المبلغ المدفوع (مثلاً 10000)
            $table->string('payment_method'); // كاش، كريمي، محفظة جوال...
            $table->string('payment_type');   // دفعة مقدمة (عربون)، أو دفعة نهائية

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
