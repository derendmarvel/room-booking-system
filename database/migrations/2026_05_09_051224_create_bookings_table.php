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
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('room_id')
                ->constrained()
                ->onDelete('cascade');
            $table->date('booking_date');
            $table->date('usage_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'completed'
            ])->default('pending');
            $table->text('purpose');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
