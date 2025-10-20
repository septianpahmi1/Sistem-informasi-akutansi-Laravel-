<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin SIAkuntansi',
            'email' => 'admin@dapur.com',
            'password' => bcrypt('password'),
            'role' => 'Admin'
        ]);
        User::create([
            'name' => 'Bendahara SIAkuntansi',
            'email' => 'bendahara@dapur.com',
            'password' => bcrypt('password'),
            'role' => 'Bendahara'
        ]);
    }
}
