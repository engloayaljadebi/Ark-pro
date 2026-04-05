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
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');       // اسم الحالة
            $table->string('color_code'); // لون الحالة في الواجهة (مثلاً أخضر للجاهز)
            $table->boolean('is_final')->default(false); // هل هذه الحالة تعني إغلاق الطلب؟
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};
