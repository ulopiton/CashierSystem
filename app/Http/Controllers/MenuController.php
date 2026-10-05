<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Menu;
use App\Models\Category;


class MenuController extends Controller{
    // Display a listing of the resource.
    public function index(){
        $menus = Menu::with('category')->latest()->get();
        return view('menus.index', compact('menus'));
    }

    // Show the form for creating a new resource.
    public function create(){
        $categories = Category::all();
        return view('menus.create', compact('categories'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request){
        $request->validates([
            'category_id'=>'required|exist:categories,id',
            'name'=>'required|string|max:255',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();

        if($request->hasFile('image')){
          $data['image'] = $request->file('image')->store('menus','public')
        }

        Menu::create($data);

        return redirect()->route('menus.index')->with('success','Menu berhasil ditambahkan');
    }

    // Display the specified resource.
    public function show(Menu $menu){
        return view('menus.show', compact('menu'));
    }

    // Show the form for editing the specified resource.
    public function edit(Menu $menu){
        $categories = Category::all();
        return view('menus.edit', compact('menu', 'categories'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Menu $menu){
        $request->validates([
            'category_id'=>'required|exist:categories,id',
            'name'=>'required|string|max:255',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();

        if($request->hasFile('image')){
          // Hapus gambar lama jika ada
          if($menu->image){
              Storage::disk('public')->delete($menu->image);
          }
          $data['image'] = $request->file('image')->store('menus','public');
        }

        $menu->update($data);

        return redirect()->route('menus.index')->with('sucess', 'Menu berhasil diperbarui');
    }

    // Remove the specified resource from storage.
    public function destroy(Menu $menu){
        if($menu->image){
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus');
    }
}
