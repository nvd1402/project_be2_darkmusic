<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tentheloai' => [
                'required',
                'max:32',
                'regex:/^[\p{L}\s0-9]+$/u'
            ],
        ]);

        Category::create([
            'tentheloai' => $request->tentheloai,
        ]);

        return redirect()->route('categories.index')->with('success', 'Thêm thể loại thành công!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tentheloai' => [
                'required',
                'max:32',
                'regex:/^[\p{L}\s0-9]+$/u'
            ],
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'tentheloai' => $request->tentheloai,
        ]);

        return redirect()->route('categories.index')->with('success', 'Cập nhật thể loại thành công!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Xóa thể loại thành công!');
    }
}
