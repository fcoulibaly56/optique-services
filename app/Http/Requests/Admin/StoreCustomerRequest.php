<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
   public function authorize(): bool { return true; }

public function rules(): array
{
    return [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20|unique:customers,phone,' . $this->customer?->id,
        'email' => 'nullable|email|max:255',
        'profession' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'birth_date' => 'nullable|date',
    ];
}

}
