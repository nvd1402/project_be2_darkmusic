<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    // Hiển thị danh sách tin tức
    public function index()
    {
        $news = News::all();  // Lấy tất cả tin tức từ database
        return view('admin.news.index', compact('news'));  // Trả về view của admin với dữ liệu tin tức
    }

    // Hiển thị form tạo mới tin tức
    public function create()
    {
        return view('admin.news.create'); // Đảm bảo đường dẫn view đúng
    }

    // Lưu tin tức mới vào database
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'tieude' => [
                'required', 
                'max:1000', 
                'regex:/^[\p{L}\s0-9][\p{L}\s0-9]*$/u'  // Không cho phép ký tự đặc biệt ở đầu
            ],
            'noidung' => 'required',  // Nội dung là bắt buộc
            'donvidang' => 'required', // Đơn vị đăng là bắt buộc
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Kiểm tra hình ảnh
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
    
        // Lưu tin tức mới
        $news = new News();
        $news->tieude = $request->tieude;
        $news->noidung = $request->noidung;
        $news->donvidang = $request->donvidang;
    
        if ($request->hasFile('hinhanh')) {
            // Nếu có file hình ảnh thì lưu nó
            $imagePath = $request->file('hinhanh')->store('news_images', 'public');
            $news->hinhanh = $imagePath;
        }
    
        $news->save();
    
        return redirect()->route('admin.news.index')->with('success', 'Tin tức đã được thêm thành công!');
    }
    

    // Hiển thị form chỉnh sửa tin tức
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));  // Trả về view chỉnh sửa tin tức
    }

    // Cập nhật tin tức
    public function update(Request $request, $id)
    {


        
        // Xác thực dữ liệu với các thông báo lỗi
        $request->validate([
            'tieude' => [
                'required',
                'max:1000',
                'regex:/^[\p{L}\s0-9]+$/u', // Không cho phép ký tự đặc biệt
            ],
            'noidung' => 'required', // Nội dung là bắt buộc
            'donvidang' => 'required|max:255', // Đơn vị đăng là bắt buộc và có độ dài tối đa là 255 ký tự
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Hình ảnh có thể có hoặc không
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
    
        // Tìm kiếm tin tức theo ID
        $news = News::findOrFail($id);
    
        // Cập nhật các trường thông tin tin tức
        $news->tieude = $request->tieude;
        $news->noidung = $request->noidung;
        $news->donvidang = $request->donvidang;
    
        if ($request->hasFile('hinhanh')) {
            // Nếu có hình ảnh mới, lưu nó
            $imagePath = $request->file('hinhanh')->store('news_images', 'public');
            $news->hinhanh = $imagePath;
        }
    
        $news->save();  // Lưu bản ghi đã cập nhật vào cơ sở dữ liệu
    
        return redirect()->route('admin.news.index')->with('success', 'Tin tức đã được cập nhật thành công!');
    }

    // Xóa tin tức
    public function destroy($id)
    {
        // Tìm tin tức theo ID và xóa nó
        $news = News::findOrFail($id);  // Tìm tin tức theo ID
        $news->delete();  // Xóa tin tức khỏi cơ sở dữ liệu
    
        return redirect()->route('admin.news.index')->with('success', 'Đã xóa tin tức thành công!');  // Quay lại danh sách tin tức với thông báo thành công
    }
public function show($id)
{
    $news = News::findOrFail($id);

    // Lấy 5 tin khác, trừ tin đang xem
    $relatedNews = News::where('id', '!=', $news->id)
                        ->latest()
                        ->take(5)
                        ->get();

    return view('frontend.show', compact('news', 'relatedNews'));
}



}
