<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ---------------------------------------------------------
        // 1. PASSAGE TEMPORAIRE EN VARCHAR POUR PERMETTRE LES UPDATES
        // ---------------------------------------------------------
        DB::statement("ALTER TABLE orders MODIFY COLUMN status VARCHAR(255) NOT NULL DEFAULT 'received'");
        DB::statement("ALTER TABLE prescriptions MODIFY COLUMN status VARCHAR(255) NOT NULL DEFAULT 'pending'");
        DB::statement("ALTER TABLE appointments MODIFY COLUMN status VARCHAR(255) NOT NULL DEFAULT 'pending'");

        // ---------------------------------------------------------
        // 2. TRADUCTION DES DONNÉES EXISTANTES
        // ---------------------------------------------------------
        // Commandes
        DB::table('orders')->where('status', 'received')->update(['status' => 'recue']);
        DB::table('orders')->where('status', 'prescription_validated')->update(['status' => 'ordonnance_validee']);
        DB::table('orders')->where('status', 'in_production')->update(['status' => 'en_production']);
        DB::table('orders')->where('status', 'ready')->update(['status' => 'prete']);
        DB::table('orders')->where('status', 'delivered')->update(['status' => 'livree']);
        DB::table('orders')->where('status', 'cancelled')->update(['status' => 'annulee']);

        // Prescriptions
        DB::table('prescriptions')->where('status', 'pending')->update(['status' => 'en_attente']);
        DB::table('prescriptions')->where('status', 'validated')->update(['status' => 'validee']);
        DB::table('prescriptions')->where('status', 'rejected')->update(['status' => 'rejetee']);

        // Rendez-vous
        DB::table('appointments')->where('status', 'pending')->update(['status' => 'en_attente']);
        DB::table('appointments')->where('status', 'confirmed')->update(['status' => 'confirme']);
        DB::table('appointments')->where('status', 'done')->update(['status' => 'termine']);
        DB::table('appointments')->where('status', 'cancelled')->update(['status' => 'annule']);
        DB::table('appointments')->where('status', 'moved')->update(['status' => 'deplace']);

        // ---------------------------------------------------------
        // 3. RETOUR EN ENUM PROPRE AVEC LES STATUTS FRANÇAIS
        // ---------------------------------------------------------
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('recue', 'ordonnance_validee', 'en_production', 'prete', 'livree', 'annulee') NOT NULL DEFAULT 'recue'");
        DB::statement("ALTER TABLE prescriptions MODIFY COLUMN status ENUM('en_attente', 'validee', 'rejetee') NOT NULL DEFAULT 'en_attente'");
        DB::statement("ALTER TABLE appointments MODIFY COLUMN status ENUM('en_attente', 'confirme', 'termine', 'annule', 'deplace') NOT NULL DEFAULT 'en_attente'");

        // ---------------------------------------------------------
        // 4. AJOUT DES NOUVEAUX CHAMPS
        // ---------------------------------------------------------
        Schema::table('customers', function (Blueprint $table) {
            $table->string('profession')->nullable()->after('email');
            $table->string('address')->nullable()->after('profession');
            $table->date('birth_date')->nullable()->after('address');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('frame_reference')->nullable()->after('status');
            $table->decimal('frame_price', 10, 2)->default(0)->after('frame_reference');
            $table->decimal('lens_price', 10, 2)->default(0)->after('frame_price');
            // Assurer que total_amount et deposit_amount ne sont pas NULL avant de modifier
            DB::table('orders')->whereNull('total_amount')->update(['total_amount' => 0]);
            DB::table('orders')->whereNull('deposit_amount')->update(['deposit_amount' => 0]);

            $table->decimal('total_amount', 10, 2)->default(0)->change();
            $table->decimal('discount', 10, 2)->default(0)->after('total_amount');
            $table->decimal('insurance_coverage', 10, 2)->default(0)->after('discount');
            $table->decimal('net_to_pay', 10, 2)->default(0)->after('insurance_coverage');
            $table->decimal('deposit_amount', 10, 2)->default(0)->change();
            $table->decimal('remaining_amount', 10, 2)->default(0)->after('deposit_amount');
        });

        Schema::table('prescriptions', function (Blueprint $table) {
            $table->string('doctor_name')->nullable()->after('notes');
            $table->date('prescription_date')->nullable()->after('doctor_name');

            $table->string('od_sph')->nullable()->after('prescription_date');
            $table->string('od_cyl')->nullable()->after('od_sph');
            $table->string('od_axis')->nullable()->after('od_cyl');
            $table->string('od_add')->nullable()->after('od_axis');
            $table->string('od_ep')->nullable()->after('od_add');

            $table->string('og_sph')->nullable()->after('od_ep');
            $table->string('og_cyl')->nullable()->after('og_sph');
            $table->string('og_axis')->nullable()->after('og_cyl');
            $table->string('og_add')->nullable()->after('og_axis');
            $table->string('og_ep')->nullable()->after('og_add');

            $table->string('lens_type')->nullable()->after('og_ep');
        });
    }

    public function down(): void
    {
        // Pas de rollback nécessaire
    }
};
