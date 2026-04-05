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
        Schema::create('brands', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // ربط الماركة بالنشاط التجاري (لكل محل ماركاته الخاصة أو العامة)
            $table->foreignUuid('business_id')->constrained('business_profiles')->onDelete('cascade');
            $table->string('name'); // اسم الماركة
            $table->string('logo_path')->nullable(); // شعار الماركة إن وجد
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
