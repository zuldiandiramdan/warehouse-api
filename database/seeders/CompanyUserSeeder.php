<?php

namespace Database\Seeders;

use App\Models\CompanyUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyUser::factory()->count(10)->make()->unique(function ($item) {
            return $item['user_id'] . '-' . $item['company_id'];
        })->each(function ($item) {
            $item->save();
        });
    }
}
