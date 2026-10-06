<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class TransactionController extends Controller{
    // Menampilkan halaman kasir
    public function index(){
        $menus = Menu::with('category')
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();
        return view('transactions.index', compact('menus'));
    }
}