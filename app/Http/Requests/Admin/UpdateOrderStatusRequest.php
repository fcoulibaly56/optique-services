<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // Les nouveaux statuts digitaux
            'status' => 'required|string|in:en_cours,livraison_en_cours,livre_paye,annulee'
        ];
    }
}
