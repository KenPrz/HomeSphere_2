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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_name');
            $table->unsignedBigInteger('home_id');
            $table->unsignedBigInteger('room_owner_id');
            $table->string('room_icon')->nullable();
            $table->foreign('home_id')->references('id')->on('homes')->onDelete('cascade');
            $table->foreign('room_owner_id')->references('id')->on('users');
            $table->timestamps();
            // Add a unique constraint for room_name and home_id
            $table->unique(['room_name', 'home_id']);
        });        
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
