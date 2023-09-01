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
        Schema::create('home_member', function (Blueprint $table) {
            $table->unsignedBigInteger('home_id');
            $table->unsignedBigInteger('member_id');
            $table->primary(['home_id', 'member_id']);
            
            $table->foreign('home_id')->references('id')->on('homes');
            $table->foreign('member_id')->references('id')->on('users');
            
            // Add any additional columns you might need for this pivot table
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_members');
    }
};
