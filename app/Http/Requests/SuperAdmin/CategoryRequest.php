<?php

namespace App\Http\Requests\SuperAdmin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'superadmin';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $slug = Str::slug($value);

                if ($slug === '') {
                    return $fail('Le nom doit contenir des lettres ou des chiffres.');
                }

                $taken = Category::where('slug', $slug)
                    ->when($this->route('category'), fn ($q, $c) => $q->where('id', '!=', $c->id))
                    ->exists();

                if ($taken) {
                    $fail('Une catégorie avec ce nom existe déjà.');
                }
            }],
            'type'          => ['required', Rule::in(array_keys(Category::TYPES))],
            'description'   => ['nullable', 'string', 'max:1000'],
            'position'      => ['nullable', 'integer', 'min:0', 'max:9999'],
            'show_in_admin' => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'        => 'nom',
            'type'        => 'type',
            'description' => 'description',
            'position'    => 'position',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Le champ :attribute est obligatoire.',
            'in'       => 'Le type choisi est invalide.',
        ];
    }
}
