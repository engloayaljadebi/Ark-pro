<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Item;
use App\Models\StaffLedger;
use Illuminate\Support\Facades\DB;

class RepairService
{
    /**
     * إتمام عملية الإصلاح: خصم المخزن، حساب الأرباح، وتسجيل عمولة الفني.
     */
    public function completeRepair(string $orderId, string $itemId, string $technicianId): Order
    {
        return DB::transaction(function () use ($orderId, $itemId, $technicianId) {

            // 1. جلب الطلب (Order)
            $order = Order::findOrFail($orderId);

            // 2. جلب قطعة الغيار المستخدمة (Item)
            $item = Item::findOrFail($itemId);

            // 3. الحسابات المالية (Logic)
            $revenue = $order->agreed_price; // ما سيتم استلامه من العميل
            $cost = $item->cost_price;      // تكلفة القطعة علينا
            $profit = $revenue - $cost;     // صافي الربح من القطعة والعمل

            // احتساب عمولة الفني (مثال: 40% من صافي الربح)
            $commissionRate = 0.40;
            $commissionEarned = $profit * $commissionRate;

            // 4. تسجيل العملية في سجل حسابات الموظفين (Staff Ledger)
            StaffLedger::create([
                'business_profile_id' => $order->business_profile_id,
                'people_id'           => $technicianId, // المعرف الفريد للفني من جدول People
                'order_id'            => $order->id,
                'transaction_type'    => 'Commission',
                'revenue_amount'      => $revenue,
                'cost_amount'         => $cost,
                'net_profit_amount'   => $profit,
                'commission_earned'   => $commissionEarned,
                'notes'               => "عمولة إصلاح الجهاز رقم: " . ($order->order_number ?? 'N/A')
            ]);

            // 5. تحديث المخزن (خصم القطعة)
            if ($item->quantity > 0) {
                $item->decrement('quantity', 1);
            } else {
                throw new \Exception("عذراً، لا يوجد مخزون كافٍ من هذه القطعة.");
            }

            // 6. تحديث حالة الطلب (مثلاً إلى 'جاهز للتسليم')
            $order->update([
                'order_status_id' => '9ba7f52a-xxxx-xxxx-xxxx', // استبدله بـ UUID الخاص بحالة "جاهز"
                'actual_cost' => $cost
            ]);

            return $order;
        });
    }
}
