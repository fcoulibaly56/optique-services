<?php

namespace App\Exports;
use App\Models\Customer;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    public function collection(): Enumerable { return Customer::all(); }
    public function headings(): array {
        return ['ID', 'Prénom', 'Nom', 'Téléphone', 'Email', 'Profession', 'Adresse', 'Date de naissance'];
    }
}
