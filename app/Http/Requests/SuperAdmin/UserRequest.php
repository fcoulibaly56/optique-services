<?php

namespace App\Http\Requests\SuperAdmin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'superadmin';
    }

    protected function prepareForValidation(): void
    {
        // "+223 65 81 05 01" devient "65810501"
        $phone = preg_replace('/\D+/', '', (string) $this->input('phone'));
        if (strlen($phone) === 11 && str_starts_with($phone, '223')) {
            $phone = substr($phone, 3);
        }

        $this->merge([
            'email' => strtolower(trim((string) $this->input('email'))),
            'phone' => $phone !== '' ? $phone : null,
        ]);
    }

    public function rules(): array
    {
        $member = $this->route('user'); // null à la création

        return [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($member)],
            'phone'     => ['nullable', 'digits:8', Rule::unique('users', 'phone')->ignore($member)],
            'role'      => ['required', Rule::in(array_keys(User::TEAM_ROLES))],
            'password'  => [$member ? 'nullable' : 'required', 'string', 'min:8', 'max:100'],
            'is_active' => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'     => 'nom',
            'email'    => 'e-mail',
            'phone'    => 'téléphone',
            'role'     => 'rôle',
            'password' => 'mot de passe',
        ];
    }

    public function messages(): array
    {
        return [
            'required'     => 'Le champ :attribute est obligatoire.',
            'email.email'  => "L'adresse e-mail n'est pas valide.",
            'email.unique' => 'Cet e-mail est déjà utilisé par un autre compte.',
            'phone.digits' => 'Le téléphone doit contenir 8 chiffres.',
            'phone.unique' => 'Ce numéro est déjà utilisé par un autre compte (client ou équipe).',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'role.in'      => 'Le rôle choisi est invalide.',
        ];
    }
}
