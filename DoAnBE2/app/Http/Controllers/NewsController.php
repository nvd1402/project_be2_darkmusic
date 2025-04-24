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
            'tieude' => 'required|max:255',  // Tiêu đề là bắt buộc và có độ dài tối đa là 255 ký tự
            'noidung' => 'required',         // Nội dung là bắt buộc
            'donvidang' => 'required|max:255', // Đơn vị đăng là bắt buộc và có độ dài tối đa là 255 ký tự
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Hình ảnh có thể có hoặc không, nếu có thì phải là ảnh và có dung lượng tối đa 2MB
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
        return view('admin.news.edit', compact('news')); // Đảm bảo đường dẫn đúng
    }
    

    // Cập nhật tin tức
    public function update(Request $request, $id)
    {
        // Validate the input fields
        $data = $request->validate([
            'tieude' => 'required',  // Title is required
            'noidung' => 'required',  // Content is required
            'donvidang' => 'required',  // Publisher is required
            'hinhanh' => 'image|nullable',  // Image is optional but if provided, must be an image
        ]);

        // Find the news by ID
        $news = News::findOrFail($id);

        // If there's a new image, store it
        if ($request->hasFile('hinhanh')) {
            $data['hinhanh'] = $request->file('hinhanh')->store('images', 'public');
        }

        // Update the news record
        $news->update($data);

        // Redirect to the news index page with a success message
        return redirect()->route('admin.news.index')->with('success', 'Cập nhật thành công');
    }

    // Xóa tin tức
    public function destroy($id)
    {
        $news = News::findOrFail($id);  // Find the news by ID
        $news->delete();  // Delete the news record

        // Redirect to the news index page with a success message
        return redirect()->route('admin.news.index')->with('success', 'Đã xóa tin');
    }
}
