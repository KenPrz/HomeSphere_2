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
        Schema::create('modes', function (Blueprint $table) {
            $table->id();
            $table->string('mode_name');
            $table->unsignedBigInteger('home_id');
            $table->unsignedBigInteger('created_by');
            $table->string('mode_description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreign('created_by')->references('member_id')->on('home_members')->onDelete('cascade');
            $table->foreign('home_id')->references('id')->on('homes')->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modes');
    }
};
