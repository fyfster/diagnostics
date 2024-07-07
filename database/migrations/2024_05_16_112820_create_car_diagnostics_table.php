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
        Schema::create('car_diagnostics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id');
            $table->integer('speed')->nullable();
            $table->integer('rpm')->nullable();
            $table->integer('fuel_percentage')->nullable();
            $table->integer('coolant_temperature')->nullable();
            $table->integer('fuel_rate')->nullable();
            $table->integer('engine_load')->nullable();
            $table->string('dtc')->nullable();
            $table->integer('total_km')->nullable();
            $table->timestamp('created_at', 0)->nullable();
            $table->unsignedBigInteger('race_number')->default(0);

            $table->foreign('car_id')->references('id')->on('cars');
            $table->index(['car_id', 'race_number']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_diagnostics');
    }
};
