<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            // ASSETS
            ['code' => '101', 'name' => 'Kas', 'type' => 'asset', 'opening_balance' => 5000000],
            ['code' => '102', 'name' => 'Bank', 'type' => 'asset', 'opening_balance' => 10000000],
            ['code' => '103', 'name' => 'Piutang Usaha', 'type' => 'asset', 'opening_balance' => 3000000],

            // LIABILITIES
            ['code' => '201', 'name' => 'Hutang Usaha', 'type' => 'liability', 'opening_balance' => 2000000],
            ['code' => '202', 'name' => 'Hutang Bank', 'type' => 'liability', 'opening_balance' => 5000000],

            // EQUITY
            ['code' => '301', 'name' => 'Modal Pemilik', 'type' => 'equity', 'opening_balance' => 10000000],
            ['code' => '302', 'name' => 'Laba Ditahan', 'type' => 'equity', 'opening_balance' => 0],

            // INCOME
            ['code' => '401', 'name' => 'Pendapatan Penjualan', 'type' => 'income', 'opening_balance' => 0],
            ['code' => '402', 'name' => 'Pendapatan Non Operasional', 'type' => 'income', 'opening_balance' => 0],

            // EXPENSE
            ['code' => '501', 'name' => 'Harga Pokok Penjualan', 'type' => 'cost', 'opening_balance' => 0],
            // EXPENSE
            ['code' => '601', 'name' => 'Beban Pokok Penjualan', 'type' => 'expense', 'opening_balance' => 0],
            ['code' => '602', 'name' => 'Beban Operasional', 'type' => 'expense', 'opening_balance' => 0],
            ['code' => '603', 'name' => 'Beban Non Operasional', 'type' => 'expense', 'opening_balance' => 0],
        ];

        foreach ($accounts as $account) {
            Account::updateOrCreate(
                ['code' => $account['code']],
                $account
            );
        }
    }
}
