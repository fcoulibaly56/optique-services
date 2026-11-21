<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('contact_requests', function (Blueprint $table) {
        $table->timestamp('consent_at')->nullable()->default(null)->change();
    });
}

public function down(): void
{
    Schema::table('contact_requests', function (Blueprint $table) {
        $table->timestamp('consent_at')->useCurrent()->useCurrentOnUpdate()->change();
    });
}
};
