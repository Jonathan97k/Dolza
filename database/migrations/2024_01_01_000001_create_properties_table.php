<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('type');
            $table->string('location');
            $table->decimal('price', 15, 2);
            $table->text('details')->nullable();
            $table->string('status')->default('pending');
            $table->string('image')->nullable();
            $table->boolean('featured')->default(false);
            $table->string('bedrooms')->nullable();
            $table->string('bathrooms')->nullable();
            $table->string('area')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
