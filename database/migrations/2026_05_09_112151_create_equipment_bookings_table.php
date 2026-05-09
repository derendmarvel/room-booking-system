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
        Schema::create('equipment_bookings', function (Blueprint $table) {
            $table->id();

            // Parent booking (weak entity dependency)
            $table->foreignId('room_booking_id')
                ->constrained()
                ->onDelete('cascade');

            // Tool / equipment reference
            $table->foreignId('equipment_id')
                ->constrained('equipment')
                ->onDelete('cascade');

            // Quantity borrowed
            $table->unsignedInteger('quantity');

            $table->timestamps();

            // Prevent duplicate tool in same booking
            $table->unique(['room_booking_id', 'equipment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_bookings');
    }
};
