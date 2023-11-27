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
        Schema::create('mode_device_activation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mode_id');
            $table->unsignedBigInteger('device_id');
            $table->enum('activation_type', ['schedule', 'sensor'])->default('schedule');
            $table->json('activation_details')->nullable();
            $table->timestamps();

            $table->foreign('mode_id')->references('id')->on('modes')->onDelete('cascade');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mode_device_activation');
    }
};
