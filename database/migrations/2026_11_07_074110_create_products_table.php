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
        Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained()->cascadeOnUpdate();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('brand')->nullable();
    $table->string('material')->nullable();
    $table->string('size')->nullable();
    $table->decimal('price', 10, 2)->nullable();
    $table->enum('price_mode', ['fixed', 'from', 'on_request'])->default('on_request');
    $table->unsignedInteger('stock')->nullable();
    $table->boolean('is_visible')->default(true);
    $table->boolean('is_available')->default(true);
    $table->timestamps();
    $table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
