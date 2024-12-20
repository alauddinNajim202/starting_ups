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
        Schema::create('business_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('cover')->nullable();
            $table->string('business_name');
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->enum('activity', ['Indoor', 'Outdoor'])->default('Indoor');
            $table->string('operation_days_start')->nullable();
            $table->string('operation_days_end')->nullable();
            $table->time('open_time')->default('00:00:00');
            $table->time('close_time')->default('00:00:00');
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_profiles');
    }
};
