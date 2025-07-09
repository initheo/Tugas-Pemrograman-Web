<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    { 
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now()
        ]); 

        // Create sample regular users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Bob Wilson',
            'email' => 'bob@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now()
        ]);
    }

}
