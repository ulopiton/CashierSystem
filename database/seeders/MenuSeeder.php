<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder{
    public function run(): void{
      $appetizer = Category::where('name','Appetizer')->first();
      $maincourse = Category::where('name','Main Course')->first();
      $dessert = Category::where('name','Dessert')->first();
      $drink = Category::where('name','Drink')->first();
      
      Menu::create([
         'category_id'=>$appetizer->id,
         'name'=>'Roti Canai',
         'price'=>10000,
         'stock'=>10,
      ]);
      Menu::create([
         'category_id'=>$maincourse->id,
         'name'=>'Nasi Goreng Hong Kong',
         'price'=>25000,
         'stock'=>10,
      ]);
      Menu::create([
         'category_id'=>$dessert->id,
         'name'=>'Es Campur',
         'price'=>15000,
         'stock'=>10,
      ]);
      Menu::create([
         'category_id'=>$drink->id,
         'name'=>'Americano',
         'price'=>90000,
         'stock'=>10,
      ]);
    }
}
