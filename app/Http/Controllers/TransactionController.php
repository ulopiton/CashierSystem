<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Menu;

class TransactionController extends Controller
{
	// Menampilkan halaman kasir
	public function index(Request $request)
	{
		$menus = Menu::with("category")
			->where("stock", ">", 0)
			->orderBy("name")
			->get();

		$cart = $request->session()->get("cart", []);

		return view("transactions.index", compact("menus", "cart"));
	}

	// Menambahkan menu ke keranjang
	public function addToCart(Request $request)
	{
		$request->validate([
			"menu_id" => "required|exists:menus,id",
			"quantity" => "required|integer|min:1",
		]);

		$menu = Menu::findOrFail($request->menu_id);

		// Cek stok
		if ($menu->stock < $request->quantity) {
			if ($request->expectsJson()) {
				return response()->json(
					[
						"success" => false,
						"message" => "Jumlah melebihi stok yang tersedia.",
					],
					422
				);
			}

			return redirect()
				->route("transactions.index")
				->with("error", "Jumlah melebihi stok yang tersedia.");
		}

		$cart = $request->session()->get("cart", []);

		$menuId = $menu->id;

		// Jika menu sudah ada di cart
		if (isset($cart[$menuId])) {
			$newQuantity = $cart[$menuId]["quantity"] + $request->quantity;

			// Cek total quantity dengan stok
			if ($newQuantity > $menu->stock) {
				if ($request->expectsJson()) {
					return response()->json(
						[
							"success" => false,
							"message" => "Jumlah melebihi stok yang tersedia.",
						],
						422
					);
				}

				return redirect()
					->route("transactions.index")
					->with("error", "Jumlah melebihi stok yang tersedia.");
			}

			$cart[$menuId]["quantity"] = $newQuantity;

			$cart[$menuId]["subtotal"] = $cart[$menuId]["price"] * $newQuantity;
		} else {
			// Menu baru
			$cart[$menuId] = [
				"menu_id" => $menu->id,
				"name" => $menu->name,
				"price" => $menu->price,
				"quantity" => $request->quantity,
				"subtotal" => $menu->price * $request->quantity,
			];
		}

		$request->session()->put("cart", $cart);

		// RESPONSE AJAX

		if ($request->expectsJson()) {
			$total = 0;

			foreach ($cart as $item) {
				$total += $item["subtotal"];
			}

			return response()->json([
				"success" => true,
				"message" => "Menu berhasil ditambahkan ke keranjang.",
				"cart" => $cart,
				"total" => $total,
			]);
		}
	}

	// Mengubah jumlah item di keranjang
	public function updateCart(Request $request)
	{
		$request->validate([
			"menu_id" => "required|exists:menus,id",
			"quantity" => "required|integer|min:1",
		]);

		$menu = Menu::findOrFail($request->menu_id);

		$cart = $request->session()->get("cart", []);

		// Pastikan item memang ada di cart
		if (!isset($cart[$menu->id])) {
			if ($request->expectsJson()) {
				return response()->json(
					[
						"success" => false,
						"message" => "Menu tidak ditemukan di keranjang.",
					],
					404
				);
			}

			return redirect()
				->route("transactions.index")
				->with("error", "Menu tidak ditemukan di keranjang.");
		}

		// Cek stok terbaru
		if ($request->quantity > $menu->stock) {
			if ($request->expectsJson()) {
				return response()->json(
					[
						"success" => false,
						"message" => "Jumlah melebihi stok yang tersedia.",
					],
					422
				);
			}

			return redirect()
				->route("transactions.index")
				->with("error", "Jumlah melebihi stok yang tersedia.");
		}

		$cart[$menu->id]["quantity"] = $request->quantity;

		$cart[$menu->id]["subtotal"] =
			$cart[$menu->id]["price"] * $request->quantity;

		$request->session()->put("cart", $cart);

		// RESPONSE AJAX
		if ($request->expectsJson()) {
			$total = 0;

			foreach ($cart as $item) {
				$total += $item["subtotal"];
			}

			return response()->json([
				"success" => true,
				"message" => "Jumlah menu berhasil diperbarui.",
				"cart" => $cart,
				"total" => $total,
			]);
		}
	}

	// Memproses pembayaran
	public function payment(Request $request)
	{
		$request->validate([
			"payment_amount" => "required|numeric|min:0",
		]);

		$cart = $request->session()->get("cart", []);

		if (empty($cart)) {
			return redirect()
				->route("transactions.index")
				->with("error", "Keranjang masih kosong.");
		}

		$total = 0;

		foreach ($cart as $item) {
			$total += $item["subtotal"];
		}

		$payment = $request->payment_amount;

		if ($payment < $total) {
			return redirect()
				->route("transactions.index")
				->with("error", "Pembayaran kurang dari total transaksi.");
		}

		$change = $payment - $total;

		$transaction = DB::transaction(function () use (
			$cart,
			$total,
			$payment,
			$change
		) {
			$invoiceNumber = "INV-" . now()->format("YmdHis");

			$transaction = Transaction::create([
				"invoice_number" => $invoiceNumber,
				"total_amount" => $total,
				"payment_amount" => $payment,
				"change_amount" => $change,
			]);

			foreach ($cart as $item) {
				$menu = Menu::findOrFail($item["menu_id"]);

				if ($menu->stock < $item["quantity"]) {
					throw new \Exception("Stok menu {$menu->name} tidak mencukupi.");
				}

				TransactionDetail::create([
					"transaction_id" => $transaction->id,
					"menu_id" => $menu->id,
					"quantity" => $item["quantity"],
					"price" => $item["price"],
					"subtotal" => $item["subtotal"],
				]);

				$menu->decrement("stock", $item["quantity"]);
			}

			return $transaction;
		});

		$request->session()->forget("cart");
		$request->session()->forget("payment");

		return redirect()->route("transactions.receipt", $transaction->id);
	}

	// Buat struk untuk dicetak
	public function receipt(Transaction $transaction)
	{
		$transaction->load("details.menu");

		return view("transactions.receipt", compact("transaction"));
	}

	// History transaksi
	public function history(Request $request)
	{
		$query = Transaction::query();

		if ($request->filled("invoice")) {
			$query->where("invoice_number", "like", "%" . $request->invoice . "%");
		}

		if ($request->filled("date_from")) {
			$query->whereDate("created_at", ">=", $request->date_from);
		}

		if ($request->filled("date_to")) {
			$query->whereDate("created_at", "<=", $request->date_to);
		}

		$transactions = $query->latest()->get();

		return view("transactions.history", compact("transactions"));
	}

	// Menghapus item dari keranjang
	public function removeFromCart(Request $request)
	{
		$request->validate([
			"menu_id" => "required|exists:menus,id",
		]);

		$cart = $request->session()->get("cart", []);

		if (!isset($cart[$request->menu_id])) {
			if ($request->expectsJson()) {
				return response()->json(
					[
						"success" => false,
						"message" => "Menu tidak ditemukan di keranjang.",
					],
					404
				);
			}

			return redirect()
				->route("transactions.index")
				->with("error", "Menu tidak ditemukan di keranjang.");
		}

		unset($cart[$request->menu_id]);

		$request->session()->put("cart", $cart);

		// RESPONSE AJAX
		if ($request->expectsJson()) {
			$total = 0;

			foreach ($cart as $item) {
				$total += $item["subtotal"];
			}

			return response()->json([
				"success" => true,
				"message" => "Menu berhasil dihapus dari keranjang.",
				"cart" => $cart,
				"total" => $total,
			]);
		}
	}

	// Detail transaksi
	public function show(Transaction $transaction)
	{
		$transaction->load("details.menu");

		return view("transactions.show", compact("transaction"));
	}
}
