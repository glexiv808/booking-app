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
        Schema::create('booking_courts', function (Blueprint $table) {
            $table->id('booking_court_id')->primary();
            $table->uuid('booking_id');
            $table->uuid('court_id');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('price');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('court_id')->references('court_id')->on('courts')->onDelete('cascade');
            $table->foreign('booking_id')->references('booking_id')->on('booking')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_courts');
    }
};
