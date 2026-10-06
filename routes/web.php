<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

// Redirect halaman utama ke login atau dashboard
Route::get("/", function () {
  return redirect()->route("menus");
});

// Route yang membutuhkan otentikasi (User harus login)

// Dashboard utama
Route::get("/dashboard", function () {
  return view("dashboard");
})->name("dashboard");
// 1. ROUTE KATEGORI (Category)
Route::resource("categories", CategoryController::class);
// 2. ROUTE MENU
Route::resource("menus", MenuController::class);
// 3. ROUTE TRANSAKSI (Order)
// Hanya menggunakan index, create, store, show, dan destroy
Route::resource("orders", OrderController::class)->except(["edit", "update"]);
// 4. ROUTE MANAJEMEN USER (User)
// Biasanya dibatasi hanya untuk role 'admin'
Route::middleware(["can:admin"])->group(function () {
  Route::resource("users", UserController::class);
});
// 5. ROUTE TRANSAKSI
Route::resource("transactions", TransactionController::class)->only(["index"]);
Route::post("/transactions/cart/add", [
  TransactionController::class,
  "addToCart",
])->name("transactions.cart.add");
Route::post("/transactions/cart/update", [
  TransactionController::class,
  "updateCart",
])->name("transactions.cart.update");
Route::post("/transactions/cart/remove", [
  TransactionController::class,
  "removeFromCart",
])->name("transactions.cart.remove");
Route::post("/transactions/payment", [
  TransactionController::class,
  "payment",
])->name("transactions.payment");
Route::get("/transactions/history", [
  TransactionController::class,
  "history",
])->name("transactions.history");
Route::get("/transactions/{transaction}/receipt", [
  TransactionController::class,
  "receipt",
])->name("transactions.receipt");

//Route::middleware(['auth'])->group(function () {});
