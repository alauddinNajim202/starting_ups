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
            $table->string('name')->nullable();


            $table->string('full_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('country')->nullable();

            // role enum
            $table->enum('role', ['admin', 'user', 'business'])->default('user');
            $table->string('user_name')->unique();
            $table->string('email')->unique();
            $table->string('gender')->nullable();
            $table->json('preferences')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('city')->nullable();
            $table->string('street_address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
