<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BranchStore;

class BranchStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BranchStore::create([
            'name' => 'LaundryEase Central Jakarta',
            'address' => 'Jl. Sudirman No. 123, Central Jakarta',
            'phone_number' => '021-12345678',
            'city' => 'Jakarta Pusat'
        ]);

        BranchStore::create([
            'name' => 'LaundryEase South Jakarta',
            'address' => 'Jl. TB Simatupang No. 456, South Jakarta',
            'phone_number' => '021-87654321',
            'city' => 'Jakarta Selatan'
        ]);

        BranchStore::create([
            'name' => 'LaundryEase East Jakarta',
            'address' => 'Jl. Bekasi Raya No. 789, East Jakarta',
            'phone_number' => '021-11223344',
            'city' => 'Jakarta Timur'
        ]);

        BranchStore::create([
            'name' => 'LaundryEase West Jakarta',
            'address' => 'Jl. Puri Indah No. 321, West Jakarta',
            'phone_number' => '021-55667788',
            'city' => ' Jakarta Barat'
        ]);

        BranchStore::create([
            'name' => 'LaundryEase North Jakarta',
            'address' => 'Jl. Kelapa Gading No. 654, North Jakarta',
            'phone_number' => '021-99887766',
            'city' => 'Jakarta Utara'
        ]);
    }
}
