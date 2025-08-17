<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->string('make');
            $table->string('model');
            $table->decimal('min_price', 12, 2);
            $table->decimal('max_price', 12, 2);
            $table->string('spec')->nullable();
            $table->string('energy_source');
            $table->string('engine_size');
            $table->string('no_of_cyls');
            $table->string('hp');
            
            $table->string('final_drive')->nullable(); // Optional, if you want to track transmission type
            $table->string('transmission');
            $table->string('doors');
            $table->string('seats');
            $table->string('body_type');
            $table->string('vehicle_type');

            // $table->timestamps(); // Optional, if you want to track creation and update times
            $table->index(['make', 'model', 'year']); // Index for faster lookups



        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
