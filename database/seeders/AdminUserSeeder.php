<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (!$email || !$password) {
            $this->command?->error('Set ADMIN_EMAIL and ADMIN_PASSWORD in .env before running this seeder.');
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'TripMate Admin'),
                'password' => bcrypt($password),
                'role' => 'admin',
            ]
        );

        $this->command?->info("Admin account configured for {$email}.");
    }
}
