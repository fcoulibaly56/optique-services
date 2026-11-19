<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = ['supplier_name', 'reference', 'purchase_date', 'total_amount', 'status', 'created_by'];

    public function items() { return $this->hasMany(PurchaseItem::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }

    // ⚠️ J'AI SUPPRIMÉ LE booted() ICI.
    // La gestion du stock se fait dans le Contrôleur pour éviter les doublons.
}
