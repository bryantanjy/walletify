<?php

namespace Database\Seeders;

use App\Models\ExpenseSharingGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSharingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExpenseSharingGroup::factory()->count(5)->create();
    }
}
