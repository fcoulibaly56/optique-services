<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Créer 5 clients de test
        for ($i = 1; $i <= 5; $i++) {
            $user = User::firstOrCreate(
                ['email' => "client$i@test.com"],
                [
                    'name' => "Client Test $i",
                    'password' => Hash::make('password'),
                    'role' => 'client',
                    'phone' => "7600000$i"
                ]
            );

            $customer = Customer::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => "Prénom $i",
                    'last_name' => "Nom $i",
                    'phone' => "7600000$i",
                    'email' => "client$i@test.com"
                ]
            );

            // Créer 1 à 3 commandes par client
            for ($j = 1; $j <= rand(1, 3); $j++) {
                Order::create([
                    'customer_id' => $customer->id,
                    'reference' => 'CMD-' . strtoupper(uniqid()),
                    'status' => collect(['recue', 'en_production', 'prete', 'livree'])->random(),
                    'total_amount' => rand(15000, 150000),
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}
