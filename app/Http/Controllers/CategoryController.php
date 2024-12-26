<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroy(Category $category)
    {
        // Hapus kategori
        $category->delete();

        // Redirect kembali ke halaman tasks.index dengan pesan sukses
        return redirect()->route('tasks.index')->with('success', 'Kategori berhasil dihapus.');
    }
}

