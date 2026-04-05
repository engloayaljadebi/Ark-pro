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
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // اسم الدور (Manager, Technician, Receptionist)
            $table->string('name');

            // وصف الدور (مثلاً: صلاحيات كاملة، أو صيانة فقط)
            $table->text('description')->nullable();

            // الصلاحيات بصيغة JSON (مثلاً: {"can_delete": true, "can_view_reports": false})
            $table->json('permissions')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
