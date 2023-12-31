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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email')->unique();
            $table->boolean('has_changed_email')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('has_login_alerts')->default(false);
            $table->string('password');
            $table->string('profile_image')->nullable();
            $table->boolean('has_home')->default(false);
            $table->boolean('is_online')->default(false);
            $table->dateTime('name_updated_at')->nullable();
            $table->boolean('receive_motion_alerts')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
