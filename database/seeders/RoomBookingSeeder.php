<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomBooking;
use App\Models\EquipmentBooking;
use App\Models\User;
use App\Models\Room;
use App\Models\Equipment;
use Carbon\Carbon;

class RoomBookingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', '!=', 'admin')->get();
        $rooms = Room::all();
        $equipment = Equipment::all();

        if ($users->isEmpty() || $rooms->isEmpty()) {
            return;
        }

        // ==========================
        // PAST BOOKINGS (completed/approved/rejected)
        // ==========================
        for ($i = 0; $i < 8; $i++) {

            $date = Carbon::now()->subDays(rand(3, 15));
            $start = rand(8, 14);
            $end = $start + rand(1, 3);

            $booking = RoomBooking::create([
                'user_id' => $users->random()->id,
                'room_id' => $rooms->random()->id,
                'usage_date' => $date->toDateString(),
                'start_time' => sprintf('%02d:00:00', $start),
                'end_time' => sprintf('%02d:00:00', $end),
                'status' => collect(['approved', 'completed', 'rejected'])->random(),
                'purpose' => 'Past booking scenario #' . ($i + 1),
                'booking_date' => $date->copy()->subDays(2),
            ]);

            // Attach equipment
            $this->attachEquipment($booking, $equipment);
        }

        // ==========================
        // FUTURE BOOKINGS (pending)
        // ==========================
        for ($i = 0; $i < 10; $i++) {

            $date = Carbon::now()->addDays(rand(1, 10));
            $start = rand(8, 15);
            $end = $start + rand(1, 3);

            $booking = RoomBooking::create([
                'user_id' => $users->random()->id,
                'room_id' => $rooms->random()->id,
                'usage_date' => $date->toDateString(),
                'start_time' => sprintf('%02d:00:00', $start),
                'end_time' => sprintf('%02d:00:00', $end),
                'status' => 'pending',
                'purpose' => 'Upcoming booking #' . ($i + 1),
                'booking_date' => now(),
            ]);

            $this->attachEquipment($booking, $equipment);
        }
    }

    /**
     * Attach 1–3 equipment items to booking
     */
    private function attachEquipment($booking, $equipment)
    {
        $items = $equipment->random(rand(1, 3));

        foreach ($items as $item) {

            EquipmentBooking::create([
                'room_booking_id' => $booking->id,
                'equipment_id' => $item->id,
                'quantity' => rand(1, 2),
            ]);
        }
    }
}