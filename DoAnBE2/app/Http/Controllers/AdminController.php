<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Song;
use App\Models\Artist;
use App\Models\category;
use App\Models\Userss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public $data = [];

    // Dashboard
    public function adminindex()
    {
        $soLuongBaiHat = Song::count(); // Lấy tổng số bài hát
        $this->data['soLuongBaiHat'] = $soLuongBaiHat; // Truyền số lượng sang view
        return view('admin.dashboard', $this->data);
    }

    // Song
    public function createsong()
    {
        $this->data['categories'] = Category::all();
        $this->data['artists'] = Artist::all();
        return view('admin.songs.create', $this->data);
    }

    public function storesong(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'tenbaihat' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s]+$/u'],
            'nghesi' => 'required|exists:artists,id', // Kiểm tra xem ID nghệ sĩ có tồn tại trong bảng 'artists' không
            'theloai' => 'required|string|max:100',
            'file_amthanh' => 'required|file|mimes:mp3,wav,ogg',
            'anh_daidien' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $song = new Song();
        $song->tenbaihat = $validated['tenbaihat'];
        $song->nghesi = $validated['nghesi']; // Gán ID nghệ sĩ
        $song->theloai = $validated['theloai'];

        if ($request->hasFile('file_amthanh')) {
            $pathAudio = $request->file('file_amthanh')->store('songs/audio', 'public');
            $song->file_amthanh = $pathAudio;
        }

        if ($request->hasFile('anh_daidien')) {
            $pathImage = $request->file('anh_daidien')->store('songs/images', 'public');
            $song->anh_daidien = $pathImage;
        }

        $song->save();

        return redirect()->route('admin.songs.index')->with('success', 'Thêm bài hát thành công!');
    }

    public function indexsong()
    {
        $this->data['songs'] = Song::all(); // Lấy tất cả bài hát
        return view('admin.songs.index', $this->data); // Truyền vào view
    }


    public function editsong($id)
    {
        $this->data['song'] = Song::findOrFail($id);
        $this->data['categories'] = Category::all();
        $this->data['artists'] = Artist::all(); // Thêm dòng này để lấy tất cả nghệ sĩ
        return view('admin.songs.edit', $this->data);
    }


    public function updatesong(Request $request, $id)
    {
        // Validate dữ liệu từ form
        $validated = $request->validate([
            'tenbaihat' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s]+$/u'],
            'nghesi' => 'required|exists:artists,id', // Kiểm tra xem ID nghệ sĩ có tồn tại trong bảng 'artists' không
            'theloai' => 'required|string|max:100',
            'file_amthanh' => 'nullable|file|mimes:mp3,wav,ogg',
            'anh_daidien' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        // Tìm bài hát theo ID
        $song = Song::findOrFail($id);
        $song->tenbaihat = $request->tenbaihat;
        $song->nghesi = $request->nghesi; // Cập nhật ID nghệ sĩ
        $song->theloai = $request->theloai;

        // Kiểm tra nếu có file âm thanh mới
        if ($request->hasFile('file_amthanh')) {
            if ($song->file_amthanh && Storage::disk('public')->exists($song->file_amthanh)) {
                Storage::disk('public')->delete($song->file_amthanh);
            }
            $song->file_amthanh = $request->file('file_amthanh')->store('songs/audio', 'public');
        }

        // Kiểm tra nếu có ảnh đại diện mới
        if ($request->hasFile('anh_daidien')) {
            $avatarPath = $request->file('anh_daidien')->store('songs/images', 'public');
            $song->anh_daidien = $avatarPath;
        }

        // Lưu bài hát với dữ liệu mới
        $song->save();

        // Quay lại trang danh sách bài hát
        return redirect()->route('admin.songs.index')->with('success', 'Cập nhật bài hát thành công!');
    }




    public function deletesong($id)
    {
        $song = Song::findOrFail($id);

        if ($song->file_amthanh && Storage::disk('public')->exists($song->file_amthanh)) {
            Storage::disk('public')->delete($song->file_amthanh);
        }

        if ($song->anhdaidien && Storage::disk('public')->exists($song->anhdaidien)) {
            Storage::disk('public')->delete($song->anhdaidien);
        }

        $song->delete();

        return redirect()->route('admin.songs.index')->with('success', 'Xóa bài hát thành công!');
    }
    public function search(Request $request)
    {
            $query = $request->input('query');
            $songs = Song::where('nghesi', 'like', "%$query%")
                ->orWhere('tenbaihat', 'like', "%$query%")
                ->get();

            return view('admin.songs.index', compact('songs'));
    }

    // User
    public function indexuser()
    {
        return view('admin.users.index', $this->data);
    }

    public function createuser()
    {
        return view('admin.users.create', $this->data);
    }

    public function edituser($id)
    {
        $this->data['user'] = User::findOrFail($id);
        return view('admin.users.edit', $this->data);
    }

    // Doanh thu
    public function revenue()
    {
        return view('admin.revenue.index', $this->data);
    }
}
