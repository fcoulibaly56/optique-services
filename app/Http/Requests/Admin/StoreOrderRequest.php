<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
   public function authorize(): bool { return true; }

 public function rules(): array
{
    return [
        'customer_id' => 'required|exists:customers,id',
        'frame_reference' => 'nullable|string|max:255',
        // Le prix de la monture n'est obligatoire QUE si is_pec n'est pas envoyé
        'frame_price' => 'required_unless:is_pec,1|nullable|numeric|min:0',
        'lens_price' => 'required|numeric|min:0',
        'discount' => 'nullable|numeric|min:0',
        'insurance_id' => 'nullable|exists:insurances,id',
        'deposit_amount' => 'nullable|numeric|min:0',
        'delivery_date' => 'nullable|date|after_or_equal:today',
        'frame_product_id' => 'nullable|exists:products,id',
        // Ordonnance
        'doctor_name' => 'nullable|string',
        'prescription_date' => 'nullable|date',
        'od_sph' => 'nullable|string', 'od_cyl' => 'nullable|string', 'od_axis' => 'nullable|string', 'od_add' => 'nullable|string', 'od_ep' => 'nullable|string',
        'og_sph' => 'nullable|string', 'og_cyl' => 'nullable|string', 'og_axis' => 'nullable|string', 'og_add' => 'nullable|string', 'og_ep' => 'nullable|string',
        'lens_type' => 'nullable|string',
    ];
}
}
