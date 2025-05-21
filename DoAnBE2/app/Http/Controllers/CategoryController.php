<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $nhoms = [
        'Nhạc Rock',
        'Nhạc Remix',
        'Nhạc Nổi Bật',
        'Nhạc Mới',
    ];

    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $nhoms = $this->nhoms; // truyền danh sách nhóm
        return view('admin.categories.create', compact('nhoms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tentheloai' => ['required', 'max:32', 'regex:/^[\p{L}\s0-9]+$/u'],
            'nhom' => ['required', 'in:' . implode(',', $this->nhoms)], // validate nhóm phải thuộc danh sách
        ]);

        Category::create([
            'tentheloai' => $request->tentheloai,
            'nhom' => $request->nhom,
        ]);

        return redirect()->route('categories.index')->with('success', 'Thêm thể loại thành công!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $nhoms = $this->nhoms; // truyền danh sách nhóm
        return view('admin.categories.edit', compact('category', 'nhoms'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tentheloai' => ['required', 'max:32', 'regex:/^[\p{L}\s0-9]+$/u'],
            'nhom' => ['required', 'in:' . implode(',', $this->nhoms)],
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'tentheloai' => $request->tentheloai,
            'nhom' => $request->nhom,
        ]);

        return redirect()->route('categories.index')->with('success', 'Cập nhật thể loại thành công!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Xóa thể loại thành công!');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        $newsList = Category::where('id', $id)->latest()->paginate(10);

        return view('frontend.category_show', compact('category', 'newsList'));
    }
}
