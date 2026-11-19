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
        Schema::create('appointments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
    $table->string('reference')->unique();
    $table->enum('motive', ['eye_exam', 'frame_try_on', 'pick_up', 'other']);
    $table->dateTime('requested_at');
    $table->unsignedInteger('duration_minutes')->default(30);
    $table->enum('status', ['pending', 'confirmed', 'done', 'cancelled', 'moved'])->default('pending');
    $table->text('comment')->nullable();
    $table->string('guest_name')->nullable();
    $table->string('guest_phone')->nullable();
    $table->string('guest_email')->nullable();
    $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
