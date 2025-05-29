<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Ad;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    // Hiển thị tất cả tin tức (trang admin)
public function index(Request $request)
{
    $page = $request->query('page');

    if ($page !== null && !is_numeric($page)) {
        return redirect()->route('admin.news.index')->with('error', 'Tham số phân trang không hợp lệ.');
    }

    $news = News::orderBy('updated_at', 'desc')->get();
    return view('admin.news.index', compact('news'));
}


    // Tìm kiếm tin tức theo từ khóa (trang admin)
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect()->route('admin.news.index');
        }

        $news = News::where('tieude', 'like', "%{$query}%")
                    ->orWhere('donvidang', 'like', "%{$query}%")
                    ->get();

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->tieude = $this->normalizeNumbers($request->tieude);
$request->donvidang = $this->normalizeNumbers($request->donvidang);
        $request->validate([
            'tieude' => [
                'required',
                'max:1000',
                'regex:/^[\p{L}\s0-9][\p{L}\s0-9]*$/u'
            ],
            'noidung' => 'required',
            'donvidang' => [
                'required',
                'max:255',
                'regex:/^[\p{L}\s0-9][\p{L}\s0-9]*$/u'
            ],
            'hinhanh' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'tieude.required' => 'Vui lòng nhập tiêu đề.',
            'tieude.max' => 'Tiêu đề không được vượt quá :max ký tự.',
            'tieude.regex' => 'Tiêu đề không được bắt đầu bằng ký tự đặc biệt.',
            'noidung.required' => 'Vui lòng nhập nội dung.',
            'donvidang.required' => 'Vui lòng nhập đơn vị đăng.',
            'donvidang.max' => 'Đơn vị đăng không được vượt quá 255 ký tự.',
            'donvidang.regex' => 'Đơn vị đăng không được chứa ký tự đặc biệt.',
            'hinhanh.required' => 'Vui lòng chọn ảnh cho tin tức.',
            'hinhanh.image' => 'Hình ảnh phải là một tệp ảnh hợp lệ.',
            'hinhanh.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'hinhanh.max' => 'Hình ảnh không được vượt quá 2MB.',
        ]);

        // Kiểm tra nội dung không chứa HTML
        $content = $request->input('noidung');
        if ($content !== strip_tags($content)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['noidung' => 'Nội dung không được chứa mã HTML.']);
        }

        // Kiểm tra khoảng trắng full-width (2 bytes)
        if ($this->isOnlyWhitespace($request->tieude)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['tieude' => 'Tiêu đề không được chứa khoảng trắng không hợp lệ.']);
        }
        if ($this->isOnlyWhitespace($request->donvidang)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['donvidang' => 'Đơn vị đăng không được chứa khoảng trắng không hợp lệ.']);
        }

        // Kiểm tra tiêu đề đã tồn tại
        $exists = News::where('tieude', $request->tieude)->exists();
        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['tieude' => 'Tiêu đề tin tức này đã tồn tại. Vui lòng làm mới trang để cập nhật dữ liệu mới nhất.']);
        }

        $news = new News();
        $news->tieude = $request->tieude;
        $news->noidung = $request->noidung;
        $news->donvidang = $request->donvidang;

        if ($request->hasFile('hinhanh')) {
            $imagePath = $request->file('hinhanh')->store('news_images', 'public');
            $news->hinhanh = $imagePath;
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'Tin tức đã được thêm thành công!');
    }

    public function edit($id)
    {
        try {
            $news = News::findOrFail($id);
            return view('admin.news.edit', compact('news'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.news.index')->with('error', 'Không tìm thấy tin tức với ID bạn yêu cầu.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $news = News::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.news.index')->with('error', 'Không tìm thấy tin tức để cập nhật.');
        }
$request->tieude = $this->normalizeNumbers($request->tieude);
$request->donvidang = $this->normalizeNumbers($request->donvidang);
        $request->validate([
            'tieude' => ['required', 'max:1000', 'regex:/^[\p{L}\s0-9][\p{L}\s0-9]*$/u'],
            'noidung' => 'required',
            'donvidang' => ['required', 'max:255', 'regex:/^[\p{L}\s0-9][\p{L}\s0-9]*$/u'],
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'updated_at' => 'required',
        ], [
            'tieude.required' => 'Vui lòng nhập tiêu đề.',
            'tieude.max' => 'Tiêu đề không được vượt quá :max ký tự.',
            'tieude.regex' => 'Tiêu đề không được bắt đầu bằng ký tự đặc biệt.',
            'noidung.required' => 'Vui lòng nhập nội dung.',
            'donvidang.required' => 'Vui lòng nhập đơn vị đăng.',
            'donvidang.max' => 'Đơn vị đăng không được vượt quá 255 ký tự.',
            'donvidang.regex' => 'Đơn vị đăng không được chứa ký tự đặc biệt.',
            'hinhanh.image' => 'Hình ảnh phải là một tệp ảnh hợp lệ.',
            'hinhanh.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'hinhanh.max' => 'Hình ảnh không được vượt quá 2MB.',
            'updated_at.required' => 'Dữ liệu không hợp lệ. Vui lòng tải lại trang.',
        ]);

        // Kiểm tra nội dung không chứa HTML
        $content = $request->input('noidung');
        if ($content !== strip_tags($content)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['noidung' => 'Nội dung không được chứa mã HTML.']);
        }

        // Kiểm tra khoảng trắng full-width (2 bytes)
        if ($this->isOnlyWhitespace($request->tieude)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['tieude' => 'Tiêu đề không được chứa khoảng trắng không hợp lệ.']);
        }
        if ($this->isOnlyWhitespace($request->donvidang)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['donvidang' => 'Đơn vị đăng không được chứa khoảng trắng không hợp lệ.']);
        }

        // So sánh updated_at gửi lên với bản ghi trong DB
        if ($request->updated_at != $news->updated_at->toDateTimeString()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['conflict' => 'Tin tức đã được chỉnh sửa bởi người dùng khác. Vui lòng tải lại trang để cập nhật dữ liệu mới nhất.']);
        }

        // Kiểm tra tiêu đề trùng lặp với bản ghi khác
        $exists = News::where('tieude', $request->tieude)
                      ->where('id', '!=', $id)
                      ->exists();
        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['tieude' => 'Tiêu đề tin tức này đã tồn tại. Vui lòng đổi tiêu đề khác.']);
        }

        $news->tieude = $request->tieude;
        $news->noidung = $request->noidung;
        $news->donvidang = $request->donvidang;

        if ($request->hasFile('hinhanh')) {
            $imagePath = $request->file('hinhanh')->store('news_images', 'public');
            $news->hinhanh = $imagePath;
        }

        $news->save();

        return redirect()->route('admin.news.index')
                         ->with('success', 'Tin tức đã được cập nhật thành công!');
    }

public function destroy(Request $request, $id)
{
    try {
        $news = News::findOrFail($id);

        $clientUpdatedAt = $request->input('updated_at');
        if (!$clientUpdatedAt || $clientUpdatedAt != $news->updated_at->toDateTimeString()) {
            return redirect()->route('admin.news.index')
                             ->with('error', 'Tin tức đã được thay đổi hoặc xóa bởi người khác. Vui lòng tải lại trang.');
        }

        $news->delete();

        return redirect()->route('admin.news.index')
                         ->with('success', 'Đã xóa tin tức thành công!');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Trường hợp tin đã bị xóa hoặc không tồn tại
        return redirect()->route('admin.news.index')
                         ->with('error', 'Tin tức bạn muốn xóa không còn tồn tại. Có thể đã bị xóa ở nơi khác.');
    } catch (\Exception $e) {
        // Trường hợp lỗi không xác định
        return redirect()->route('admin.news.index')
                         ->with('error', 'Đã xảy ra lỗi trong quá trình xóa tin tức. Vui lòng thử lại.');
    }
}



    public function show($id)
    {
        try {
            $news = News::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('frontend.news.index')->with('error', 'Không tìm thấy trang bạn yêu cầu.');
        }

        $comments = $news->comments()->with('user')->latest()->get();
        $relatedNews = News::where('id', '!=', $news->id)
                            ->latest()
                            ->take(5)
                            ->get();
        $bannerAd = Ad::where('is_active', 1)->inRandomOrder()->first();

        return view('frontend.news_show', compact('news', 'relatedNews', 'bannerAd', 'comments'));
    }

    /**
     * Kiểm tra chuỗi có chỉ chứa khoảng trắng (kể cả full-width) hay không
     */
    private function isOnlyWhitespace($string)
    {
        // Loại bỏ khoảng trắng bình thường và full-width (U+3000)
        $trimmed = preg_replace('/[\s\x{3000}]+/u', '', $string);
        return $trimmed === '';
    }
    private function normalizeNumbers($string)
{
    // Chuyển các ký tự số full-width (unicode FF10–FF19) về dạng số ASCII (0–9)
    return preg_replace_callback('/[\x{FF10}-\x{FF19}]/u', function ($matches) {
        return chr(ord($matches[0]) - 0xFEE0);
    }, $string);
}
}
