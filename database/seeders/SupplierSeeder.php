<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'name' => 'Supplier test',
            'phone' => '0812345678',
            'email' => 'supplier1@gmail.com',
            'address' => 'cianjur'
        ]);
        Customer::create([
            'name' => 'Customer test',
            'phone' => '0812345678',
            'email' => 'customer1@gmail.com',
            'address' => 'cianjur'
        ]);
    }
}
