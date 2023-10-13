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
        Schema::create('device_mode', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('mode_id');
            $table->timestamps();
        
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
            $table->foreign('mode_id')->references('id')->on('modes')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
