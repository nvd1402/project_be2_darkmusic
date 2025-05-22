<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    // Hiển thị danh sách album
    public function index()
    {
        $albums = Album::with('artist')->get(); // eager load artist để tránh N+1 query
        return view('admin.album.index', compact('albums'));
    }

    // Tìm kiếm album theo từ khóa (trang admin)
public function search(Request $request)
{
    $query = $request->input('query');

    if (!$query) {
        // Nếu không có từ khóa, quay về trang danh sách album đầy đủ
        return redirect()->route('admin.album.index');
    }

    // Tìm theo tên album hoặc nghệ sĩ
    $albums = Album::where('ten_album', 'like', "%{$query}%")
        ->orWhere('nghe_si', 'like', "%{$query}%")
        ->get();

    return view('admin.album.index', compact('albums'));
}


    // Hiển thị form tạo album
    public function create()
    {
        $artists = Artist::all();
        return view('admin.album.create', compact('artists'));
    }

    // Lưu album mới
  public function store(Request $request)
{
    $request->validate([
        'ten_album' => 'required|max:255',
        'nghe_si' => 'required|max:255',
        'anh_bia' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ], [
        'ten_album.required' => 'Vui lòng nhập tên album.',
        'nghe_si.required' => 'Vui lòng nhập tên nghệ sĩ.',
        'anh_bia.image' => 'Ảnh bìa phải là hình ảnh hợp lệ.',
    ]);

    $album = new Album();
    $album->ten_album = $request->ten_album;
    $album->nghe_si = $request->nghe_si;

    if ($request->hasFile('anh_bia')) {
        $path = $request->file('anh_bia')->store('album_images', 'public');
        $album->anh_bia = $path;
    }

    $album->save();

    return redirect()->route('admin.album.index')->with('success', 'Đã thêm album thành công!');
}

public function update(Request $request, $id)
{
    $request->validate([
        'ten_album' => 'required|max:255',
        'nghe_si' => 'required|max:255',
        'anh_bia' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $album = Album::findOrFail($id);
    $album->ten_album = $request->ten_album;
    $album->nghe_si = $request->nghe_si;

    if ($request->hasFile('anh_bia')) {
        $path = $request->file('anh_bia')->store('album_images', 'public');
        $album->anh_bia = $path;
    }

    $album->save();

    return redirect()->route('admin.album.index')->with('success', 'Cập nhật album thành công!');
}


    // Hiển thị form chỉnh sửa album
    public function edit($id)
    {
        $album = Album::findOrFail($id);
        $artists = Artist::all();
        return view('admin.album.edit', compact('album', 'artists'));
    }

    // Cập nhật album
    

    // Xoá album
    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        if ($album->image_album && Storage::disk('public')->exists($album->image_album)) {
            Storage::disk('public')->delete($album->image_album);
        }
        $album->delete();

        return redirect()->route('admin.album.index')->with('success', 'Đã xoá album thành công!');
    }

    // Hiển thị chi tiết album (nếu cần)
    public function show($id)
    {
        $album = Album::with('artist')->findOrFail($id);
        return view('frontend.album_show', compact('album'));
    }
}
