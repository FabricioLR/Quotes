<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.dashboard.default_admin_email', env('DEFAULT_ADMIN_EMAIL', 'admin@admin.com'));
        $name = config('admin.dashboard.default_admin_name', env('DEFAULT_ADMIN_NAME', 'admin'));
        $password = config('admin.dashboard.default_admin_password', env('DEFAULT_ADMIN_PASSWORD', 'admin'));

        if (!$email || !$password || !$name) {
            Log::warning('AdminSeeder skipped: DEFAULT_ADMIN_EMAIL, DEFAULT_ADMIN_PASSWORD or DEFAULT_ADMIN_NAMEenvironment variables are not set.');
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        Log::info('Default administrator account successfully synchronized via environment variables.', ['email' => $email]);
    }
}
