<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Artist;
use App\Models\News;
use Illuminate\Http\Request;
use App\Models\Ad;

class CategoryController extends Controller
{
    // Các nhóm thể loại cố định
    protected $nhoms = [
        'Nhạc Rock',
        'Nhạc Remix',
        'Nhạc Nổi Bật',
        'Nhạc Mới',
    ];

    // Trang danh sách thể loại (Admin)
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Tìm kiếm thể loại (Admin)
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect()->route('admin.categories.index');
        }

        $categories = Category::where('tentheloai', 'like', "%{$query}%")
            ->orWhere('nhom', 'like', "%{$query}%")
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    // Form thêm thể loại (Admin)
    public function create()
    {
        $nhoms = $this->nhoms;
        return view('admin.categories.create', compact('nhoms'));
    }

    // Lưu thể loại mới (Admin)
    public function store(Request $request)
    {
        $request->validate([
            'tentheloai' => 'required|string|max:255',
            'nhom' => 'required|string|in:' . implode(',', $this->nhoms),
        ]);

        Category::create([
            'tentheloai' => $request->tentheloai,
            'nhom' => $request->nhom,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm thể loại thành công!');
    }

    // Form sửa thể loại (Admin)
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $nhoms = $this->nhoms;
        return view('admin.categories.edit', compact('category', 'nhoms'));
    }

    // Cập nhật thể loại (Admin)
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

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thể loại thành công!');
    }

    // Xóa thể loại (Admin)
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa thể loại thành công!');
    }

public function show($tentheloai)
{
    $category = Category::where('tentheloai', $tentheloai)->firstOrFail();

    // Lấy danh sách các thể loại cùng nhóm, loại trừ chính nó nếu muốn
    $categoriesByNhom = Category::where('nhom', $category->nhom)
        ->where('id', '!=', $category->id)
        ->get();

    // Lấy danh sách nghệ sĩ thuộc thể loại hiện tại
    $artists = Artist::where('category_id', $category->id)->get();
     $bannerAd = Ad::where('is_active', 1)->inRandomOrder()->first();

    return view('frontend.category_show', [
        'category' => $category,
        'categoriesByNhom' => $categoriesByNhom,
        'artists' => $artists,
         'bannerAd' => $bannerAd,
    ]);
}







  
}