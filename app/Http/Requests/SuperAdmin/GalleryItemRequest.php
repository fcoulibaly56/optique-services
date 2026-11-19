<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class GalleryItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'superadmin';
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:255'],
            'note'         => ['nullable', 'string', 'max:255'],
            'position'     => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_visible'   => ['boolean'],
            'categories'   => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
            // La photo est obligatoire à la création (POST), facultative à la modification (PUT)
            'image'        => [$this->isMethod('post') ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'     => 'nom',
            'note'     => 'description courte',
            'position' => 'position',
            'image'    => 'photo',
        ];
    }

    public function messages(): array
    {
        return [
            'required'       => 'Le champ :attribute est obligatoire.',
            'image.required' => 'Veuillez choisir une photo.',
            'image.image'    => 'Le fichier doit être une image.',
            'image.mimes'    => 'La photo doit être au format JPG, PNG ou WebP.',
            'image.max'      => 'La photo ne doit pas dépasser 5 Mo.',
            'image.uploaded' => "La photo n'a pas pu être envoyée (fichier trop lourd pour le serveur ?).",
        ];
    }
}
