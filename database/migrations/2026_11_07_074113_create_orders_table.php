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
        Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
    $table->string('reference')->unique();
    $table->enum('status', [
        'received', 'prescription_validated', 'in_production', 'ready', 'delivered', 'cancelled'
    ])->default('received');
    $table->decimal('total_amount', 10, 2)->nullable();
    $table->decimal('deposit_amount', 10, 2)->nullable();
    $table->string('payment_method')->nullable();
    $table->string('payment_status')->nullable();
    $table->date('delivery_date')->nullable();
    $table->date('renewal_date')->nullable();
    $table->text('renewal_adjustment_note')->nullable();
    $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
    $table->timestamps();
    $table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
