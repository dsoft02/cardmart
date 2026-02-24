<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'ebendev09@gmail.com'],
            [
                'name' => 'Ebenezer Ogidiolu',
                'email' => 'ebendev09@gmail.com',
                'password' => Hash::make('user123'),
                'role' => User::ROLE_USER,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@epinstore.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@epinstore.com',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
                'role' => User::ROLE_ADMIN,
                'email_verified_at' => now(),
            ]
        );
    }
}
