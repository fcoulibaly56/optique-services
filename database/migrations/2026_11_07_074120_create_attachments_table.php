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
         Schema::create('attachments', function (Blueprint $table) {
    $table->id();
    $table->morphs('attachable'); // attachable_type + attachable_id
    $table->string('file_key');
    $table->string('original_name');
    $table->string('mime_type');
    $table->unsignedBigInteger('size');
    $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
