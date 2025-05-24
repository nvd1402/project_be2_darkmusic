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
    // Danh sách nhóm thể loại hợp lệ
    protected $nhoms = [
        'Nhạc Rock',
        'Nhạc Remix',
        'Nhạc Nổi Bật',
        'Nhạc Mới',
    ];

    // Hiển thị danh sách thể loại
    public function index()
    {
        $categories = Category::orderByDesc('updated_at')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Tìm kiếm thể loại
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

    // Form thêm thể loại
    public function create()
    {
        return view('admin.categories.create', [
            'nhoms' => $this->nhoms,
        ]);
    }

    // Lưu thể loại mới
    public function store(Request $request)
    {
        $request->validate([
    'tentheloai' => 'required|string|max:255',
    'nhom' => 'required|string|in:' . implode(',', $this->nhoms),
    'description' => 'required|string|max:1000',
    'status' => 'required|boolean',
    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
]);


        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category', 'public');
        }

        Category::create([
            'tentheloai' => $request->tentheloai,
            'nhom' => $request->nhom,
            'description' => $request->description,
            'status' => $request->boolean('status'),  // checkbox: trả về true/false tương ứng 1/0
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm thể loại thành công!');
    }

    // Form sửa thể loại
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', [
            'category' => $category,
            'nhoms' => $this->nhoms,
        ]);
    }

    // Cập nhật thể loại
    public function update(Request $request, $id)
    {
        $request->validate([
    'tentheloai' => 'required|string|max:255',
    'nhom' => 'required|string|in:' . implode(',', $this->nhoms),
    'description' => 'required|string|max:1000',
    'status' => 'required|boolean',
    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
]);


        $category = Category::findOrFail($id);

        $category->tentheloai = $request->tentheloai;
        $category->nhom = $request->nhom;
        $category->description = $request->description;
        $category->status = $request->boolean('status');

        // Xử lý upload ảnh mới, nếu có
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            // Lưu ảnh mới
            $category->image = $request->file('image')->store('category', 'public');
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thể loại thành công!');
    }

    // Xóa thể loại
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa thể loại thành công!');
    }

public function show($tentheloai)
{
    // Lấy thể loại phải là status = true
    $category = Category::where('tentheloai', $tentheloai)
                        ->where('status', true)
                        ->firstOrFail();

    // Lấy các thể loại cùng nhóm, đang hoạt động, trừ thể loại hiện tại
    $categoriesByNhom = Category::where('nhom', $category->nhom)
                                ->where('id', '!=', $category->id)
                                  ->where('status', true)
                               
                                ->get();

    $artists = Artist::where('category_id', $category->id)->get();

    // Với bài hát, tùy theo cột 'theloai' có thể là id category
    $songs = Song::where('theloai', $category->id)->get();
    $songs = Song::where('theloai', $category->id)->with('artist')->get();


    $bannerAd = Ad::where('is_active', 1)->inRandomOrder()->first();

    return view('frontend.category_show', compact('category', 'categoriesByNhom', 'artists', 'songs', 'bannerAd'));
}



}