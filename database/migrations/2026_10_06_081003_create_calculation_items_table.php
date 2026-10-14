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
        Schema::create('calculation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calculation_id')->constrained()->cascadeOnDelete();
            $table->char('section', 1);
            $table->string('name');
            $table->string('detail')->nullable();
            $table->decimal('qty', 10, 2);
            $table->decimal('rate', 10, 2);
            $table->string('unit')->nullable();
            $table->unsignedTinyInteger('months')->nullable();
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculation_items');
    }
};
