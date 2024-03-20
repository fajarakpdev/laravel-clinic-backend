<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DoctorSchedule;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'fajar@fic15.com',
            'role' => 'admin',
            'phone' => '081298542192',
            'password' => Hash::make('12345678'),

        ]);

        \App\Models\ProfileClinic::factory()->create([
            'name' => 'Griya Sehat Fajar',
            'address' => 'Jln A. Yani Sidoarjo',
            'phone' => '081298542192',
            'email' => 'fajar@klinik.com',
            'doctor_name' => 'dr fajar',
            'unique_code' => '234234',
        ]);

        //call doctor seeder
        $this->call([
            DoctorSeeder::class,
            DoctorScheduleSeeder::class
        ]);
    }
}
