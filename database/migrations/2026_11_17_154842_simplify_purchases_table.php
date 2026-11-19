<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('purchases', 'supplier_name')) {
                $table->string('supplier_name')->nullable()->after('id');
            }
            // On retire les colonnes trop complexes si elles existent
            if (Schema::hasColumn('purchases', 'supplier_id')) {
                $table->dropForeign(['supplier_id']);
                $table->dropColumn('supplier_id');
            }
        });

        // On simplifie les items d'achat
        Schema::table('purchase_items', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_items', 'unit_cost')) {
                $table->decimal('unit_cost', 10, 2)->nullable()->change(); // On rend le prix optionnel
            }
        });
    }
    public function down(): void {}
};
