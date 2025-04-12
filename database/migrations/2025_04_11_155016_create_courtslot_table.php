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
        Schema::create('courtslot', function (Blueprint $table) {
            $table->uuid('slot_id')->primary();
            $table->uuid('court_id')->references('court_id')->on('court')->onDelete('cascade');;
            $table->uuid('booking_court_id')->references('booking_court_id')->on('bookingCourts')->onDelete('cascade');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->boolean('is_looked');
            $table->boolean('locked_by_owner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courtslot');
    }
};
