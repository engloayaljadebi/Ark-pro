<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'order_number', 'business_id', 'customer_id', 'creator_id',
    'technician_id', 'model_id', 'type_id', 'status_id',
    'imei_serial', 'device_password', 'issue_description',
    'technical_diagnosis', 'agreed_price', 'prepaid_amount',
    'discount_amount', 'estimated_delivery', 'actual_delivery'
])]
class Order extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'agreed_price' => 'decimal:2',
            'prepaid_amount' => 'decimal:2',
            'estimated_delivery' => 'datetime',
            'actual_delivery' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(People::class, 'customer_id');
    }
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }
    public function ticketItems(): HasMany
    {
        return $this->hasMany(TicketItem::class);
    }
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
