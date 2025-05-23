<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Artist;
use App\Models\Song;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $categories = Category::orderBy('updated_at', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

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

    public function create()
    {
        $nhoms = $this->nhoms;
        return view('admin.categories.create', compact('nhoms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tentheloai' => 'required|string|max:255',
            'nhom' => 'required|string|in:' . implode(',', $this->nhoms),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Lưu ảnh vào folder 'category' trong storage/app/public
            $imagePath = $request->file('image')->store('category', 'public');
        }

        Category::create([
            'tentheloai' => $request->tentheloai,
            'nhom' => $request->nhom,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm thể loại thành công!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $nhoms = $this->nhoms;
        return view('admin.categories.edit', compact('category', 'nhoms'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tentheloai' => ['required', 'max:255'],
            'nhom' => ['required', 'in:' . implode(',', $this->nhoms)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::findOrFail($id);

        if ($request->hasFile('image')) {
            // Xoá ảnh cũ nếu có
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            // Lưu ảnh mới vào folder 'category'
            $imagePath = $request->file('image')->store('category', 'public');
            $category->image = $imagePath;
        }

        $category->tentheloai = $request->tentheloai;
        $category->nhom = $request->nhom;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thể loại thành công!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Xoá ảnh nếu có
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa thể loại thành công!');
    }

    public function show($tentheloai)
    {
        $category = Category::where('tentheloai', $tentheloai)->firstOrFail();

        $categoriesByNhom = Category::where('nhom', $category->nhom)
            ->where('id', '!=', $category->id)
            ->get();

        $artists = Artist::where('category_id', $category->id)->get();

        $songs = Song::where('theloai', $category->id)->get();

        $bannerAd = Ad::where('is_active', 1)->inRandomOrder()->first();

        return view('frontend.category_show', [
            'category' => $category,
            'categoriesByNhom' => $categoriesByNhom,
            'artists' => $artists,
            'songs' => $songs,
            'bannerAd' => $bannerAd,
        ]);
    }
}
