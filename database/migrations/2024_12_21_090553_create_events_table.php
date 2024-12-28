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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('cover')->nullable(); // Event Title
            $table->string('title'); // Event Title
            $table->integer('category_id'); // Category
            $table->integer('user_id'); // Category
            $table->integer('age_min')->nullable(); // Min Age
            $table->integer('age_max')->nullable(); // Max Age
            $table->text('description')->nullable(); // Description
            $table->date('date'); // Event Date
            $table->time('start_time'); // Start Time
            $table->time('end_time'); // End Time
            $table->enum('frequency', ['once', 'daily', 'weekly', 'monthly'])->default('once'); // Frequency
            $table->integer('frequency_count')->nullable(); // Repetition Interval
            $table->integer('frequency_end_after')->nullable(); // Repetition End Count
            $table->date('frequency_end_date')->nullable(); // Repetition End Date
            $table->string('location_type')->default('physical'); // Location Type
            $table->string('location_address')->nullable(); // Address
            $table->string('amount')->nullable(); // Event Cost
            $table->text('offerings')->nullable(); // Offerings
            $table->boolean('has_guests')->default(false); // Guests Allowed
            $table->json('guest_list')->nullable(); // Guest Emails
            $table->json('guest_options')->nullable(); // Guest Options
            $table->text('note_for_guests')->nullable(); // Notes for Guests
            $table->timestamps(); // Timestamps
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
