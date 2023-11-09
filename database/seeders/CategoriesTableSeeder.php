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
            ['category_name' => 'Food & Drink'],
            ['category_name' => 'Housing'],
            ['category_name' => 'Shopping'],
            ['category_name' => 'Travel'],
            ['category_name' => 'Transportation'],
            ['category_name' => 'Utilities'],
            ['category_name' => 'Entertainment'],
            ['category_name' => 'Education'],
            ['category_name' => 'Personal Care'],
            ['category_name' => 'Gift & Donations'],
            ['category_name' => 'Investments'],
            ['category_name' => 'Health & Fitness'],
            ['category_name' => 'Miscellaneous'],
            ['category_name' => 'Income'],
        ];

        // Insert the categories into the 'categories' table
        DB::table('categories')->insert($categories);
    }
}
