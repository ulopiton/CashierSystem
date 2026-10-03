<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder{
    public function run(): void{
      $makanan = Category::where('name','Makanan')->first();
      $minuman = Category::where('name','Minuman')->first();

      Menu::create([
                   'category_id'=>$makanan->id,
                   'name'=>'Pudding Cokelat Pak Hambali',
                   'price'=>25000,
                   'stock'=>10,
      ]);

      Menu::create([
                   'category_id'=>$minuman->id,
                   'name'=>'Jus Apel Ijo',
                   'price'=>20000,
                   'stock'=>10,
      ]);
    }
}
