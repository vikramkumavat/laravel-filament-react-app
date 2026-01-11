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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->text('owner_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->foreignId('property_type_id')->constrained()->onDelete('cascade');
            $table->decimal('emd_price', 12, 2);
            $table->decimal('price', 12, 2)->nullable();
            $table->string('location')->nullable();
            $table->string('sq_ft')->nullable();
            // $table->decimal('starting_price', 12, 2)->nullable();
            $table->enum('status', ['pending', 'done'])->default('pending');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
