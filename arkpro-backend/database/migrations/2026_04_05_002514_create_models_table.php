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
        Schema::create('models', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // ربط الموديل بالماركة (مثلاً S22 مرتبط بـ Samsung)
            $table->foreignUuid('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('name'); // اسم الموديل
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};
