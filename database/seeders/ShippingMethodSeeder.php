<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shipping::create([
            'name' => 'Vận chuyển hỏa tốc (trong ngày)',
            'cost' => 45000,
        ]);
    }
}