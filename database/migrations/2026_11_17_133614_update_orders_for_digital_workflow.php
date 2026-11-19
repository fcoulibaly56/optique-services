<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up(): void {
    Schema::table('orders', function (Blueprint $table) {
        // 1. Les nouveaux statuts (les 3 classeurs digitaux)
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('en_cours', 'livraison_en_cours', 'livre_paye', 'annulee') NOT NULL DEFAULT 'en_cours'");

        // 2. Le P.E.C (Monture fournie par le client)
        $table->boolean('is_pec')->default(false)->after('insurance_id');

        // 3. Lien direct vers l'ordonnance saisie
        $table->foreignId('prescription_id')->nullable()->constrained()->nullOnDelete()->after('customer_id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
