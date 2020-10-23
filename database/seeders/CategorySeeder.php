<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ["title" => "New Category"],
            ["title" => "Uncategorize"],
        ];

        foreach ($categories as $category)
            Category::create(array_merge($category, ["slug" => Str::slug($category["title"])]));
    }
}
