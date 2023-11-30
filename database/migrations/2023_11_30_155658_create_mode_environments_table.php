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
        Schema::create('mode_environments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mode_id');
            $table->enum('trigger_sensor',['temperature','humidity'])->nullable();
            $table->enum('threshold',['above','below','specifically'])->nullable();
            $table->float('value', 8, 2)->nullable();
            $table->unsignedBigInteger('room_id')->nullable();

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('mode_id')->references('id')->on('modes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mode_environments');
    }
};
