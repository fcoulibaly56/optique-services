<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Insurance;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Str;

class ShopDataSeeder extends Seeder
{
    public function run(): void
    {

        // 2. Catégories
        $catHomme = Category::firstOrCreate(['slug' => 'homme'], ['name' => 'Homme', 'type' => 'frame']);
        $catFemme = Category::firstOrCreate(['slug' => 'femme'], ['name' => 'Femme', 'type' => 'frame']);
        $catSolaire = Category::firstOrCreate(['slug' => 'solaire'], ['name' => 'Solaire', 'type' => 'sunglasses']);

        // 3. Produits (Avec les fameuses références complexes et les slugs !)
        Product::create([
            'category_id' => $catHomme->id,
            'name' => 'Monture Titanium Noire',
            'slug' => 'monture-titanium-noire-' . Str::random(4), // <-- AJOUTÉ
            'reference' => 'TR30_6003_S4-17_C2',
            'reference_normalisee' => 'TR306003S417C2',
            'price' => 70000,
            'price_mode' => 'fixed',
            'stock' => 5,
            'is_visible' => true,
        ]);

        Product::create([
            'category_id' => $catFemme->id,
            'name' => 'Monture Acétate Écaille',
            'slug' => 'monture-acetate-ecaille-' . Str::random(4), // <-- AJOUTÉ
            'reference' => 'AC55_8821_S2-14_C1',
            'reference_normalisee' => 'AC558821S214C1',
            'price' => 45000,
            'price_mode' => 'fixed',
            'stock' => 3,
            'is_visible' => true,
        ]);

        Product::create([
            'category_id' => $catSolaire->id,
            'name' => 'Lunettes Solaires Ray-Ban',
            'slug' => 'lunettes-solaires-rayban-' . Str::random(4), // <-- AJOUTÉ
            'reference' => 'RB2140_5001',
            'reference_normalisee' => 'RB21405001',
            'price' => 85000,
            'price_mode' => 'fixed',
            'stock' => 2,
            'is_visible' => true,
        ]);

        // Un produit en rupture de stock (pour tester les alertes)
        Product::create([
            'category_id' => $catHomme->id,
            'name' => 'Monture Métal Dorée',
            'slug' => 'monture-metal-doree-' . Str::random(4), // <-- AJOUTÉ
            'reference' => 'MT99_1122',
            'reference_normalisee' => 'MT991122',
            'price' => 30000,
            'price_mode' => 'fixed',
            'stock' => 0,
            'is_visible' => true,
        ]);

        // 4. Créer un compte client (pour tester les commandes)
        $user = User::firstOrCreate(
            ['phone' => '78169191'],
            [
                'name' => 'Enf Haïla Adam',
                'email' => 'haila@test.com',
                'password' => bcrypt('password'),
                'role' => 'client',
            ]
        );

        Customer::firstOrCreate(
            ['phone' => '78169191'],
            [
                'user_id' => $user->id,
                'first_name' => 'Adam',
                'last_name' => 'Enf Haïla',
                'email' => 'haila@test.com',
                'address' => 'Bamako',
            ]
        );
    }
}
