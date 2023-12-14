<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            ['name' => 'Food and Drink'],
            ['name' => 'Housing'],
            ['name' => 'Shopping'],
            ['name' => 'Travel'],
            ['name' => 'Transportation'],
            ['name' => 'Utilities'],
            ['name' => 'Entertainment'],
            ['name' => 'Education'],
            ['name' => 'Personal Care'],
            ['name' => 'Gift and Donations'],
            ['name' => 'Investments'],
            ['name' => 'Health and Fitness'],
            ['name' => 'Miscellaneous'],
            ['name' => 'Income'],
        ];

        // Insert the categories into the 'categories' table
        DB::table('categories')->insert($categories);
    }
}
