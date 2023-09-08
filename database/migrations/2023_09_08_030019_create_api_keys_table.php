<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('home_api_keys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('home_id');
            $table->string('api_key', 64)->unique();
            $table->timestamps();
    
            $table->foreign('home_id')->references('id')->on('homes');
        });
    }
    
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};
