<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. On passe le status en VARCHAR pour ne plus jamais avoir de problème de ENUM
        DB::statement("ALTER TABLE orders MODIFY COLUMN status VARCHAR(255) NOT NULL DEFAULT 'en_cours'");

        // 2. Ajout des nouveaux champs (sécurisé)
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'is_pec')) {
                $table->boolean('is_pec')->default(false)->after('insurance_id');
            }
            if (!Schema::hasColumn('orders', 'prescription_id')) {
                $table->foreignId('prescription_id')->nullable()->constrained()->nullOnDelete()->after('customer_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'prescription_id')) {
                $table->dropForeign(['prescription_id']);
                $table->dropColumn('prescription_id');
            }
            if (Schema::hasColumn('orders', 'is_pec')) {
                $table->dropColumn('is_pec');
            }
        });
    }
};
