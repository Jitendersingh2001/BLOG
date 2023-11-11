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
            ['category' => 'Tech'],
            ['category' => 'Fashion'],
            ['category' => 'Beauty'],
            ['category' => 'Health'],
            ['category' => 'Fitness'],
            // Add more categories as needed
        ];


        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
    }
}
