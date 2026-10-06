<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Menu;
use App\Models\Category;

class MenuController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $menus = Menu::with('category')->latest()->get();

        return view('menus.index', compact('menus'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        $categories = Category::all();

        return view('menus.create', compact('categories'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();

            $image->move(
                public_path('uploads/menus'),
                $filename
            );

            $data['image'] = 'uploads/menus/' . $filename;
        }

        Menu::create($data);

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    // Display the specified resource.
    public function show(Menu $menu)
    {
        return view('menus.show', compact('menu'));
    }

    // Show the form for editing the specified resource.
    public function edit(Menu $menu)
    {
        $categories = Category::all();

        return view('menus.edit', compact('menu', 'categories'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {

            // Hapus gambar lama jika ada
            if ($menu->image) {

                $oldImage = public_path($menu->image);

                if (File::exists($oldImage)) {
                    File::delete($oldImage);
                }
            }

            // Upload gambar baru
            $image = $request->file('image');

            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();

            $image->move(
                public_path('uploads/menus'),
                $filename
            );

            $data['image'] = 'uploads/menus/' . $filename;
        }

        $menu->update($data);

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil diperbarui');
    }

    // Remove the specified resource from storage.
    public function destroy(Menu $menu)
    {
        // Hapus gambar jika ada
        if ($menu->image) {

            $imagePath = public_path($menu->image);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $menu->delete();

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil dihapus');
    }
}