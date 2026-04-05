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
        Schema::create('salary_payouts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('business_id')->constrained('business_profiles');

            // الموظف الذي استلم فلوسه (أحمد)
            $table->foreignUuid('staff_id')->constrained('people');

            $table->decimal('amount_paid', 15, 2); // المبلغ الذي استلمه فعلياً
            $table->string('payment_method');      // كاش، كريمي...
            $table->timestamp('payout_date');      // تاريخ الاستلام
            $table->text('notes')->nullable();     // "تصفية عمولات شهر مارس"

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_payouts');
    }
};
