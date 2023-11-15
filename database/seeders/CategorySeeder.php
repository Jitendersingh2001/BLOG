<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define an array of categories
        $categories = [
            ['category' => 'Business'],
            ['category' => 'Education'],
            ['category' => 'Food and Recipe '],
            ['category' => 'Music'],
            ['category' => 'Automotive'],
            ['category' => 'Marketing'],
            ['category' => 'Internet services'],
            ['category' => 'Sports'],
            ['category' => 'Entertainment'],
            ['category' => 'Agriculture'],
            // Add more categories as needed
        ];


        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
    }
}
