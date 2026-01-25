<?php

namespace Database\Seeders;

use App\Models\TransactionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trType = TransactionType::insert([
            [
                'type_name' => 'Pemasukan',
                'is_decreasing' => false,
            ],
            [
                'type_name' => 'Pengeluaran',
                'is_decreasing' => true,
            ]
        ]);
    }
}
