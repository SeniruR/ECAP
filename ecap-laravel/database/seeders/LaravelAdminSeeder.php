<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LaravelAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD', 'change-me-now');
        $name = env('ADMIN_NAME', 'Administrator');

        // Insert or update into Laravel users table so Breeze auth can use it
        DB::table('users')->updateOrInsert(
            ['email' => $email],
            [
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
