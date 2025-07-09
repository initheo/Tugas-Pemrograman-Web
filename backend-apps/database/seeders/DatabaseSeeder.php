<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data (optional, comment out if you want to keep existing data)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\User::truncate();
        \App\Models\Customer::truncate();
        \App\Models\BranchStore::truncate();
        \App\Models\Voucher::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            UserSeeder::class,          // Create users first
            CustomerSeeder::class,      // Then create customers linked to users
            BranchStoreSeeder::class,   // Create branch stores
            VoucherSeeder::class,       // Create vouchers
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin credentials: admin@gmail.com / password');
        $this->command->info('User credentials: john@gmail.com, jane@gmail.com, bob@gmail.com / password');
    }

}
