<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder{
    public function run(): void{
        Category::create([
            'name'=>'Appetizer'
        ]);
        Category::create([
            'name'=>'Main Course'
        ]);
        Category::create([
            'name'=>'Dessert'
        ]);
        Category::create([
             'name'=>'Drink'
        ]);
    }
}
