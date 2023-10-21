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
        Schema::create('motion_sensors', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(false);
            $table->boolean('motion_detected')->default(false);
            $table->foreignId('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motion_sensors');
    }
};
