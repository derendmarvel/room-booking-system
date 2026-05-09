<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'phone_number' => '+628129214482',
            'identity_number'=> '00000000001',
            'role'=> 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin123',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Derend Marvel',
            'phone_number' => '+6285785541218',
            'identity_number'=> '0706012210030',
            'role'=> 'lecturer',
            'email' => 'derend101@gmail.com',
            'password' => 'derend123',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
