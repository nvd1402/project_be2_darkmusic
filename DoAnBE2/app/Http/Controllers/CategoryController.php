<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Artist;
use App\Models\Song;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    // Chuẩn hóa và loại bỏ khoảng trắng full-width
    protected function cleanInput($string)
    {
        // Loại bỏ khoảng trắng thường và full-width ở đầu và cuối
        $string = preg_replace('/^[\s　]+|[\s　]+$/u', '', $string);
        return $string;
    }

    // Lọc HTML không an toàn trong mô tả (loại bỏ thẻ script, iframe, v.v)
    protected function sanitizeDescription($html)
    {
        // Cách đơn giản: loại bỏ tất cả thẻ HTML
        // Nếu cần giữ HTML an toàn có thể dùng package HTMLPurifier
        return strip_tags($html);
    }

    // Chuyển số full-width sang half-width
    protected function normalizeNumbers($string)
    {
        return preg_replace_callback('/[０-９]/u', function ($matches) {
            return chr(ord($matches[0]) - 0xFEE0);
        }, $string);
    }

    // Lưu thể loại mới
    public function store(Request $request)
    {
        $request->merge([
            'tentheloai' => $this->cleanInput($request->tentheloai),
            'description' => $this->sanitizeDescription($request->description),
        ]);

        $request->validate([
            'tentheloai' => 'required|string|max:255',
            'nhom' => 'required|string|in:' . implode(',', $this->nhoms),
            'description' => 'required|string|max:1000',
            'status' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Kiểm tra tên thể loại đã tồn tại chưa
        $exists = Category::where('tentheloai', $request->tentheloai)->exists();
        if ($exists) {
            return redirect()->back()->withErrors(['tentheloai' => 'Tên thể loại đã tồn tại'])->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category', 'public');
        }

        Category::create([
            'tentheloai' => $request->tentheloai,
            'nhom' => $request->nhom,
            'description' => $request->description,
            'status' => $request->boolean('status'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm thể loại thành công!');
    }

    // Form sửa thể loại
    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.categories.index')->withErrors('Thể loại không tồn tại hoặc đã bị xóa.');
        }

        return view('admin.categories.edit', [
            'category' => $category,
            'nhoms' => $this->nhoms,
        ]);
    }

    // Cập nhật thể loại
    public function update(Request $request, $id)
    {
        $request->merge([
            'tentheloai' => $this->cleanInput($request->tentheloai),
            'description' => $this->sanitizeDescription($request->description),
        ]);

        $request->validate([
            'tentheloai' => 'required|string|max:255',
            'nhom' => 'required|string|in:' . implode(',', $this->nhoms),
            'description' => 'required|string|max:1000',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'updated_at' => 'required', // kiểm tra xung đột
        ]);

        try {
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.categories.index')->withErrors('Thể loại không tồn tại hoặc đã bị xóa.');
        }

        // So sánh updated_at để kiểm tra xung đột
        if ($request->updated_at != $category->updated_at->toDateTimeString()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['conflict' => 'Thể loại đã được chỉnh sửa bởi người dùng khác. Vui lòng tải lại trang để cập nhật dữ liệu mới nhất.']);
        }

        // Kiểm tra trùng tên thể loại với bản ghi khác
        $exists = Category::where('tentheloai', $request->tentheloai)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['tentheloai' => 'Tên thể loại này đã tồn tại. Vui lòng chọn tên khác.']);
        }

        // Cập nhật dữ liệu
        $category->tentheloai = $request->tentheloai;
        $category->nhom = $request->nhom;
        $category->description = $request->description;
        $category->status = $request->boolean('status');

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có và tồn tại file
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            // Lưu ảnh mới
            $category->image = $request->file('image')->store('category', 'public');
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thể loại thành công!');
    }

    // Xóa thể loại
public function destroy(Request $request, $id)
{
    try {
        $category = Category::findOrFail($id);

        $clientUpdatedAt = $request->input('updated_at');
        if (!$clientUpdatedAt || $clientUpdatedAt != $category->updated_at->toDateTimeString()) {
            return redirect()->route('admin.categories.index')
                ->withErrors(['conflict' => 'Thể loại đã được cập nhật hoặc thay đổi bởi người dùng khác. Vui lòng tải lại trang để có dữ liệu mới nhất.']);
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa thể loại thành công!');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->route('admin.categories.index')
            ->withErrors(['error' => 'Thể loại không tồn tại hoặc đã bị xóa.']);
    } catch (\Exception $e) {
        return redirect()->route('admin.categories.index')
            ->withErrors(['error' => 'Đã xảy ra lỗi trong quá trình xóa thể loại. Vui lòng thử lại.']);
    }
}



    // Hiển thị chi tiết thể loại
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
        $songs = Song::where('theloai', $category->id)->with('artist')->get();

        $bannerAd = Ad::where('is_active', 1)->inRandomOrder()->first();

        return view('frontend.category_show', compact('category', 'categoriesByNhom', 'artists', 'songs', 'bannerAd'));
    }
}
