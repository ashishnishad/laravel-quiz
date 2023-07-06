<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'id' => 1,
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'name' => 'Admin Admin',
            'email' => 'admin@quiz.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
