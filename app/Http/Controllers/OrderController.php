<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Menu;

class OrderController extends Controller{
    // Display a listing of the resource.
    public function index(){
        $orders = Order::with('user')->latest()->get();
        return view('orders.index', compact('orders'));
    }
  
    // Show the form for creating a new resource.
    public function create(){
        $menus = Menu::where('stock', '>', 0)->get();
        return view('orders.create', compact('menus'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request){
        $request->validates([
            'payment'=>'required|numeric|min:0',
            'items'=>'required|array|min:1',
            'items.*.menu_id'=>'required|exists:menus,id',
            'items.*.quantity'=>'required|integer|min:1',
        ]);

        return DB::transaction(function()use($request){
            $total = 0;
            $orderDetailsData = [];

            //1. Hitung total dan validasi stok menu
            foreach($request->items as $item){
              $menu = Menu::findOrFail($item['menu_id']);

              if($menu->stock < $item['quantity']){
                return back()->withErrors(["Stok untuk menu {$menu->name} tidak mencukupi"])->withInput();
              }

              $subtotal = $menu->price * $item['quantity'];
              $total += $subtotal;

              // Kurangi stok menu
              $menu->decrement('stock', $item['quantity']);
              $orderDetailsData[] = [
                'menu_id'=>$menu->id,
                'quantity'=>$item['quantity'],
                'price'=>$menu->price,
                'subtotal'=>$subtotal,
              ];
            }
          
            //2. Validasi pembayaran
            if($request->payment < $total){
              return back()->withErrors(['Uang pembayaran kurang dari total tagihan'])->withInput();
            }

            $change = $request->payment - $total;

            //3. Simpan data order
            $order = Order::create([
                 'user_id'=>auth()->id() ?? 1, //Menggunakan ID user login
                 'order_number'=>'ORD-' . strtoupper(Str::random(8)),
                 'total'=>$total,
                 'payment'=>$request->payment,
                 'change'=>$change,
            ]);

            //4. Simpan OrderDetail
            foreach($orderDetailsData as $detail){
              $detail['order_id'] = $order-id;
              OrderDetail::create($detail);
            }

          return redirect()->route('orders.show', $order->id)->with('success', 'Transaksi berhasil dibuat');
        });
    }

    // Display the specified resource.
    public function show(Order $order){
        $order->load(['user', 'orderDetails.menu']);
        return view('order.show', compact('order'));
    }

    /* Show the form for editing the specified resource.
    public function edit(string $id){} */
  
    /* Update the specified resource in storage.
    public function update(Request $request, string $id){} */

    // Remove the specified resource from storage.
    public function destroy(Order $order){
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Data transaksi berhasil dihapus');
    }
}
