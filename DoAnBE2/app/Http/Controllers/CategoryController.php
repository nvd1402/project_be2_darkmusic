<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories')); // sửa path view
    }

    public function create() {
        return view('admin.categories.create'); // sửa path view
    }

    public function store(Request $request) {
        $request->validate([
            'tentheloai' => 'required'
        ]);

        Category::create([
            'tentheloai' => $request->tentheloai,
        ]);

        return redirect()->route('categories.index')->with('success', 'Thêm thành công!');
    }

    public function edit($id) {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category')); // sửa path view
    }

    public function update(Request $request, $id) {
        $request->validate([
            'tentheloai' => 'required'
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'tentheloai' => $request->tentheloai,
        ]);

        return redirect()->route('categories.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id) {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Xóa thành công!');
    }


    // public function search(Request $request)
    // {
    //     $query = $request->input('query');
    
    //     $categories = Category::where('tentheloai', 'like', "%$query%")->get();
    
    //     return view('admin.categories.index', compact('categories'));
    // }
    
    
}
