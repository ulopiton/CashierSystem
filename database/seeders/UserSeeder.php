<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder{
    public function run(): void{
        User::create([
           'name'=>'ulo admin',
           'email'=>'uloadmin@cashiersystem.com',
           'password'=>Hash::make('123456'),
           'role'=>'admin',
        ]);
        User::create([
           'name'=>'ulo kasir',
           'email'=>'ulokasir@cashiersystem.com',
           'password'=>Hash::make('123456'),
           'role'=>'kasir',
        ]);
    }
}
