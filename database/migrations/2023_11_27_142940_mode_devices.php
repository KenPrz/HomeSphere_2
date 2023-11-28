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
        Schema::create('mode_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mode_id');
            $table->json('device_list')->nullable();
            $table->timestamps();
            $table->foreign('mode_id')->references('id')->on('modes')->onDelete('cascade');
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
