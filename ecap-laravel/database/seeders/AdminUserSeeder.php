<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD', 'change-me-now');
        $name = env('ADMIN_NAME', 'Administrator');

        DB::table('adm_u')->updateOrInsert(
            ['adm_e' => $email],
            [
                'adm_p' => Hash::make($password),
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
