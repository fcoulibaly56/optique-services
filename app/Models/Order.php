<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {
    use SoftDeletes;

    protected $fillable = [
        'customer_id', 'reference', 'status', 'frame_reference', 'frame_price',
        'lens_price', 'total_amount', 'discount', 'insurance_coverage', 'net_to_pay',
        'deposit_amount', 'remaining_amount', 'payment_method', 'payment_status',
        'delivery_date', 'renewal_date', 'renewal_adjustment_note', 'created_by',
        'insurance_id', 'is_pec', 'prescription_id','frame_product_id'
    ];

    protected $casts = [
        'delivery_date' => 'date',
        'renewal_date'  => 'date',
        'total_amount'  => 'decimal:2',
        'deposit_amount'=> 'decimal:2',
    ];

    public function prescription() { return $this->belongsTo(Prescription::class); }
    public function customer() { return $this->belongsTo(Customer::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
    public function statusHistory() { return $this->hasMany(OrderStatusHistory::class)->latest(); }
    public function conversations() { return $this->hasMany(Conversation::class); }
    public function insurance() { return $this->belongsTo(Insurance::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function frameProduct() {
    return $this->belongsTo(Product::class, 'frame_product_id');
}
}
