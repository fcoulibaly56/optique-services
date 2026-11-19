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
         Schema::create('follow_ups', function (Blueprint $table) {
    $table->id();
    $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
    $table->enum('type', ['renewal', 'unclaimed_order', 'pending_appointment']);
    $table->date('scheduled_for');
    $table->enum('status', ['pending', 'sent', 'responded', 'closed'])->default('pending');
    $table->timestamp('sent_at')->nullable();
    $table->timestamp('responded_at')->nullable();
    $table->text('message_template')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
