<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;
use Carbon\Carbon;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // New Year Voucher (already expired for testing)
        Voucher::create([
            'name' => 'New Year Discount',
            'discount_percentage' => 20.00,
            'valid_from' => Carbon::parse('2025-01-01'),
            'valid_until' => Carbon::parse('2025-01-31'),
        ]);

        // Summer Sale (currently active)
        Voucher::create([
            'name' => 'Summer Sale',
            'discount_percentage' => 15.00,
            'valid_from' => Carbon::parse('2025-06-01'),
            'valid_until' => Carbon::parse('2025-08-31'),
        ]);

        // First Time Customer (long term active)
        Voucher::create([
            'name' => 'First Time Customer',
            'discount_percentage' => 10.00,
            'valid_from' => Carbon::parse('2025-01-01'),
            'valid_until' => Carbon::parse('2025-12-31'),
        ]);

        // Weekend Special (currently active)
        Voucher::create([
            'name' => 'Weekend Special',
            'discount_percentage' => 25.00,
            'valid_from' => Carbon::parse('2025-07-01'),
            'valid_until' => Carbon::parse('2025-07-31'),
        ]);

        // Loyalty Customer (currently active, long term)
        Voucher::create([
            'name' => 'Loyal Customer Bonus',
            'discount_percentage' => 30.00,
            'valid_from' => Carbon::parse('2025-07-01'),
            'valid_until' => Carbon::parse('2025-12-31'),
        ]);

        // Student Discount (currently active)
        Voucher::create([
            'name' => 'Student Discount',
            'discount_percentage' => 15.00,
            'valid_from' => Carbon::parse('2025-07-01'),
            'valid_until' => Carbon::parse('2025-09-30'),
        ]);

        // Future voucher (not yet active)
        Voucher::create([
            'name' => 'Christmas Special',
            'discount_percentage' => 35.00,
            'valid_from' => Carbon::parse('2025-12-01'),
            'valid_until' => Carbon::parse('2025-12-31'),
        ]);

        // Past voucher (expired)
        Voucher::create([
            'name' => 'Spring Sale',
            'discount_percentage' => 20.00,
            'valid_from' => Carbon::parse('2025-03-01'),
            'valid_until' => Carbon::parse('2025-05-31'),
        ]);
    }
}