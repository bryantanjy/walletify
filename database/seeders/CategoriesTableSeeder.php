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
            ['category_id' => 'C01', 'category_name' => 'Food & Drink'],
            ['category_id' => 'C02', 'category_name' => 'Housing'],
            ['category_id' => 'C03', 'category_name' => 'Shopping'],
            ['category_id' => 'C04', 'category_name' => 'Travel'],
            ['category_id' => 'C05', 'category_name' => 'Transportation'],
            ['category_id' => 'C06', 'category_name' => 'Utilities'],
            ['category_id' => 'C07', 'category_name' => 'Entertainment'],
            ['category_id' => 'C08', 'category_name' => 'Education'],
            ['category_id' => 'C09', 'category_name' => 'Personal Care'],
            ['category_id' => 'C10', 'category_name' => 'Gift & Donations'],
            ['category_id' => 'C11', 'category_name' => 'Investments'],
            ['category_id' => 'C12', 'category_name' => 'Health & Fitness'],
            ['category_id' => 'C13', 'category_name' => 'Miscellaneous'],
            ['category_id' => 'C14', 'category_name' => 'Income'],
        ];

        // Insert the categories into the 'categories' table
        DB::table('categories')->insert($categories);
    }
}
