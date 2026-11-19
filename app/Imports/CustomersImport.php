<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

 class CustomersImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Model|array|null {
        return new Customer([
            'first_name' => $row['prenom'],
            'last_name' => $row['nom'],
            'phone' => $row['telephone'],
            'email' => $row['email'] ?? null,
            'profession' => $row['profession'] ?? null,
            'address' => $row['adresse'] ?? null,
        ]);
    }
}
