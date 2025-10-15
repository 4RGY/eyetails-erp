<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin eyetails.co',
            'email' => 'admin@eyetails.co',
            'password' => Hash::make('password'),
            'is_admin' => true, // <-- TAMBAHKAN INI
        ]);
    }
}
