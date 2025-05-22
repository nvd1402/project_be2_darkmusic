<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Ad;


class NewsController extends Controller
{
    // Hiển thị tất cả tin tức (trang admin)
    public function index()
    {
        $news = News::all();
        return view('admin.news.index', compact('news'));
    }

    // Tìm kiếm tin tức theo từ khóa (trang admin)
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            // Nếu không có từ khóa, trả về danh sách đầy đủ
            return redirect()->route('admin.news.index');
        }

        $news = News::where('tieude', 'like', "%{$query}%")
                    ->orWhere('donvidang', 'like', "%{$query}%")
                    ->get();

        return view('admin.news.index', compact('news'));
    }

    // Các hàm create, store, edit, update, destroy bạn giữ nguyên như hiện tại

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tieude' => [
                'required', 
                'max:1000', 
                'regex:/^[\p{L}\s0-9][\p{L}\s0-9]*$/u'
            ],
            'noidung' => 'required',
            'donvidang' => 'required',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'tieude.required' => 'Vui lòng nhập tiêu đề.',
            'tieude.max' => 'Tiêu đề không được vượt quá :max ký tự.',
            'tieude.regex' => 'Tiêu đề không được bắt đầu bằng ký tự đặc biệt.',
            'noidung.required' => 'Vui lòng nhập nội dung.',
            'donvidang.required' => 'Vui lòng nhập đơn vị đăng.',
            'hinhanh.image' => 'Hình ảnh phải là một tệp ảnh hợp lệ.',
            'hinhanh.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'hinhanh.max' => 'Hình ảnh không được vượt quá :max KB.',
        ]);

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
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tieude' => [
                'required',
                'max:1000',
                'regex:/^[\p{L}\s0-9]+$/u',
            ],
            'noidung' => 'required',
            'donvidang' => 'required|max:255',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'tieude.required' => 'Vui lòng nhập tiêu đề.',
            'tieude.max' => 'Tiêu đề không được vượt quá 32 ký tự.',
            'tieude.regex' => 'Tiêu đề không được bắt đầu bằng ký tự đặc biệt.',
            'noidung.required' => 'Vui lòng nhập nội dung.',
            'donvidang.required' => 'Vui lòng nhập đơn vị đăng.',
            'donvidang.max' => 'Đơn vị đăng không được vượt quá 255 ký tự.',
            'hinhanh.image' => 'Hình ảnh phải là một tệp ảnh hợp lệ.',
            'hinhanh.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'hinhanh.max' => 'Hình ảnh không được vượt quá 2MB.',
        ]);

        $news = News::findOrFail($id);
        $news->tieude = $request->tieude;
        $news->noidung = $request->noidung;
        $news->donvidang = $request->donvidang;

        if ($request->hasFile('hinhanh')) {
            $imagePath = $request->file('hinhanh')->store('news_images', 'public');
            $news->hinhanh = $imagePath;
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'Tin tức đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Đã xóa tin tức thành công!');
    }

public function show($id)
{
    $news = News::findOrFail($id);

    // Lấy danh sách bình luận của bài news, kèm user
    $comments = $news->comments()->with('user')->latest()->get();

    $relatedNews = News::where('id', '!=', $news->id)
                        ->latest()
                        ->take(5)
                        ->get();

    // Lấy 1 quảng cáo ngẫu nhiên đang được active
    $bannerAd = Ad::where('is_active', 1)->inRandomOrder()->first();

    return view('frontend.news_show', compact('news', 'relatedNews', 'bannerAd', 'comments'));
}

}