<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ======================
        // ADMIN
        // ======================
        User::create([
            'name' => 'Admin',
            'phone_number' => '+628129214482',
            'identity_number'=> '00000000001',
            'role'=> 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // ======================
        // LECTURERS
        // ======================
        User::create([
            'name' => 'Dr. Andi Wijaya',
            'phone_number' => '+628112223334',
            'identity_number'=> '197801011234',
            'role'=> 'lecturer',
            'email' => 'andi.wijaya@university.ac.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Prof. Siti Rahma',
            'phone_number' => '+628133445566',
            'identity_number'=> '197502022345',
            'role'=> 'lecturer',
            'email' => 'siti.rahma@university.ac.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'phone_number' => '+628199887766',
            'identity_number'=> '198003033456',
            'role'=> 'lecturer',
            'email' => 'budi.santoso@university.ac.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // ======================
        // STUDENTS (MAHASISWA)
        // ======================
        $students = [
            [
                'name' => 'Ahmad Rizky',
                'phone_number' => '+628521112233',
                'identity_number'=> '220601001',
                'email' => 'ahmad.rizky@student.ac.id',
            ],
            [
                'name' => 'Salsa Aulia',
                'phone_number' => '+628522223344',
                'identity_number'=> '220601002',
                'email' => 'salsa.aulia@student.ac.id',
            ],
            [
                'name' => 'Rina Putri',
                'phone_number' => '+628533334455',
                'identity_number'=> '220601003',
                'email' => 'rina.putri@student.ac.id',
            ],
            [
                'name' => 'Dimas Pratama',
                'phone_number' => '+628544445566',
                'identity_number'=> '220601004',
                'email' => 'dimas.pratama@student.ac.id',
            ],
            [
                'name' => 'Kevin Nugraha',
                'phone_number' => '+628555556677',
                'identity_number'=> '220601005',
                'email' => 'kevin.nugraha@student.ac.id',
            ],
            [
                'name' => 'Nadia Lestari',
                'phone_number' => '+628566667788',
                'identity_number'=> '220601006',
                'email' => 'nadia.lestari@student.ac.id',
            ],
        ];

        foreach ($students as $student) {
            User::create([
                'name' => $student['name'],
                'phone_number' => $student['phone_number'],
                'identity_number'=> $student['identity_number'],
                'role'=> 'student',
                'email' => $student['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}