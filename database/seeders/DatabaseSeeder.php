<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer les utilisateurs (admin, superadmin)
        User::firstOrCreate(
            ['email' => 'admin@optique.test'],
            [
                'name' => 'Admin Équipe',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'phone' => '70000001',
            ]
        );

        User::firstOrCreate(
            ['email' => 'superadmin@optique.test'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'role' => 'superadmin',
                'phone' => '70000002',
            ]
        );

        // 2. Appeler le seeder de données de test
        $this->call([
            ShopDataSeeder::class,
        ]);
    }
}
