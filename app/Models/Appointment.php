<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model {
     protected $fillable = [
    'customer_id',
    'reference',
    'motive',
    'requested_at',
    'proposed_at',
    'duration_minutes',
    'status',
    'comment',
    'guest_name',
    'guest_phone',
    'guest_email',
    'created_by',
];
    protected $casts = ['requested_at' => 'datetime'];
    public function customer() { return $this->belongsTo(Customer::class); }
     // ---- Helpers pour l'affichage en français ----
    public function getMotiveLabelAttribute(): string
    {
        return match ($this->motive) {
            'eye_exam'      => 'Examen de la vue',
            'frame_try_on'  => 'Essayage de monture',
            'pick_up'       => 'Retrait de commande',
            'other'         => 'Autre',
            default         => ucfirst($this->motive),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'en_attente' => 'En attente',
            'confirme'   => 'Confirmé',
            'termine'    => 'Terminé',
            'annule'     => 'Annulé',
            'deplace'    => 'Déplacé',
            default      => ucfirst($this->status),
        };
    }
}
