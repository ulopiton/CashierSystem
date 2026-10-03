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

    public function run(): void{
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            MenuSeder::class;
        ]);
    }
}
