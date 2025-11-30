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
        Schema::create('medicine_alternatives', function (Blueprint $table) {
            $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
            $table->foreignId('alternative_medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->enum('alternative_type', ['generic', 'brand', 'therapeutic']);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['medicine_id', 'alternative_medicine_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_alternatives');
    }
};
