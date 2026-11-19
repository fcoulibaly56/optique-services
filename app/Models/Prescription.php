<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Prescription extends Model {

 protected $fillable = [
    'customer_id', 'file_key', 'original_name', 'mime_type', 'size', 'status',
    'validated_by', 'validated_at', 'notes',
    'doctor_name', 'prescription_date',
    'od_sph', 'od_cyl', 'od_axis', 'od_add', 'od_ep',
    'og_sph', 'og_cyl', 'og_axis', 'og_add', 'og_ep', 'lens_type'
];
    protected $casts = ['validated_at' => 'datetime'];
    public function customer()    { return $this->belongsTo(Customer::class); }
    public function validatedBy() { return $this->belongsTo(User::class, 'validated_by'); }
}
