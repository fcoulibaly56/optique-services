<?php

namespace App\Http\Requests\SuperAdmin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'superadmin';
    }

    public function rules(): array
    {
        return [
            'category_id'  => ['required', 'exists:categories,id'],
            'name'         => ['required', 'string', 'max:255'],
            'reference'    => ['nullable', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (! $value) {
                    return;
                }
                $exists = Product::where('reference_normalisee', Product::normaliser($value))
                    ->when($this->route('product'), fn ($q, $p) => $q->where('id', '!=', $p->id))
                    ->exists();
                if ($exists) {
                    $fail('Cette référence existe déjà dans le catalogue.');
                }
            }],
            'brand'        => ['nullable', 'string', 'max:255'],
            'material'     => ['nullable', 'string', 'max:255'],
            'size'         => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'price_mode'   => ['required', Rule::in(['fixed', 'from', 'on_request'])],
            'price'        => [
                Rule::requiredIf(in_array($this->input('price_mode'), ['fixed', 'from'], true)),
                'nullable', 'numeric', 'min:0', 'max:99999999.99',
            ],
            'stock'        => ['nullable', 'integer', 'min:0'],
            'is_visible'   => ['boolean'],
            'is_available' => ['boolean'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // 2 Mo
            'remove_image' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'catégorie',
            'name'        => 'nom',
            'reference'   => 'référence',
            'brand'       => 'marque',
            'material'    => 'matière',
            'size'        => 'taille',
            'price_mode'  => 'mode de prix',
            'price'       => 'prix',
            'stock'       => 'stock',
            'image'       => 'image',
        ];
    }

    public function messages(): array
    {
        return [
            'required'     => 'Le champ :attribute est obligatoire.',
            'image.image'  => 'Le fichier doit être une image.',
            'image.mimes'  => "L'image doit être au format JPG, PNG ou WebP.",
            'image.max'    => "L'image ne doit pas dépasser 2 Mo.",
            'price.numeric' => 'Le prix doit être un nombre.',
        ];
    }
}
