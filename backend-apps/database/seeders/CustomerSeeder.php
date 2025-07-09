<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all users with role 'user'
        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            // Check if customer already exists for this user
            if (!$user->customer) {
                Customer::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_number' => '08' . rand(1000000000, 9999999999), // Random phone number
                    'address' => 'Jl. Customer ' . $user->id . ' No. ' . rand(1, 100),
                    'city' => 'Jakarta',
                    'postal_code' => '1' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT)
                ]);
            }
        }

        
    }
}
