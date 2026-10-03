<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void{
        // User::factory(10)->create();

        User::create([
            'name'=>'ulo kasir',
            'email'=>'ulokasir@cashiersystem.com',
            'password'=>Hash::make('123456'),
            'role'=>'kasir',
        ]);

        $makanan = Category::create(['name'=>'Makanan']);
        $minuman = Category::create(['name'=>'Minuman']);

        Menu::create([
            'category_id'=>$makanan->id,
            'name'=>'Pudding Cokelat Pak Hambali',
            'price'=>'25000',
            'stock'=>'10',         
        ]);

        Menu::create([
            'category_id'=>$minuman->id,
            'name'=>'Jus Apel Ijo',
            'price'=>'25000',
            'stock'=>'10',         
        ]);
      
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
