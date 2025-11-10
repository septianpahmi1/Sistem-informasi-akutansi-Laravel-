<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin SIAkuntansi',
            'email' => 'superadmin@dapur.com',
            'password' => bcrypt('password'),
            'role' => 'Super Admin'
        ]);
        User::create([
            'name' => 'Owner SIAkuntansi',
            'email' => 'owner@dapur.com',
            'password' => bcrypt('password'),
            'role' => 'Owner'
        ]);
    }
}
