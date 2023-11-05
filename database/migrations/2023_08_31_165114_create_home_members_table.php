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
        Schema::create('home_members', function (Blueprint $table) {
            $table->unsignedBigInteger('home_id');
            $table->unsignedBigInteger('member_id');
            $table->primary(['home_id', 'member_id']);
            $table->enum('role', ['owner', 'member', 'pending']);
            $table->date('joined_on')->nullable();
            $table->date('applied_on')->nullable();
            $table->foreign('home_id')->references('id')->on('homes')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('users');
            //make user wait to be approved by owner
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
