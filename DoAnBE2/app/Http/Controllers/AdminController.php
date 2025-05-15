<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Category; // Đảm bảo chữ 'C' của Category là viết hoa đúng
use App\Models\Userss; // Bạn có thể muốn kiểm tra lại model này, tên Userss có vẻ không chuẩn
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
        // Đã sửa: 'theloai' bây giờ kiểm tra là số nguyên và tồn tại trong bảng categories
        $validated = $request->validate([
            'tenbaihat' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\p{L}\p{M}\d\s\-\'\.]+$/u'
            ],
            'nghesi' => 'required|exists:artists,id',
            'theloai' => 'required|exists:categories,id', // SỬA Ở ĐÂY: Kiểm tra ID thể loại
            'file_amthanh' => 'required|file|mimes:mp3,wav,ogg',
            'anh_daidien' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $song = new Song();
        $song->tenbaihat = $validated['tenbaihat'];
        $song->nghesi = $validated['nghesi']; // Gán ID nghệ sĩ
        $song->theloai = $validated['theloai']; // SỬA Ở ĐÂY: Gán ID thể loại (đã validate là số nguyên)

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
        // Đã sửa: 'theloai' bây giờ kiểm tra là số nguyên và tồn tại trong bảng categories
        $validated = $request->validate([
            'tenbaihat' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s]+$/u'],
            'nghesi' => 'required|exists:artists,id',
            'theloai' => 'required|exists:categories,id', // SỬA Ở ĐÂY: Kiểm tra ID thể loại
            'file_amthanh' => 'nullable|file|mimes:mp3,wav,ogg',
            'anh_daidien' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        // Tìm bài hát theo ID
        $song = Song::findOrFail($id);
        $song->tenbaihat = $validated['tenbaihat']; // Dùng $validated thay vì $request trực tiếp
        $song->nghesi = $validated['nghesi']; // Dùng $validated
        $song->theloai = $validated['theloai']; // SỬA Ở ĐÂY: Gán ID thể loại (đã validate là số nguyên)

        // Kiểm tra nếu có file âm thanh mới
        if ($request->hasFile('file_amthanh')) {
            if ($song->file_amthanh && Storage::disk('public')->exists($song->file_amthanh)) {
                Storage::disk('public')->delete($song->file_amthanh);
            }
            $song->file_amthanh = $request->file('file_amthanh')->store('songs/audio', 'public');
        }

        // Kiểm tra nếu có ảnh đại diện mới
        if ($request->hasFile('anh_daidien')) {
            if ($song->anh_daidien && Storage::disk('public')->exists($song->anh_daidien)) {
                Storage::disk('public')->delete($song->anh_daidien);
            }
            $song->anh_daidien = $request->file('anh_daidien')->store('songs/images', 'public');
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

        // Chú ý: bạn đang dùng 'anhdaidien' ở đây, trong khi các chỗ khác là 'anh_daidien'.
        // Hãy đảm bảo tên cột là nhất quán. Tôi đã sửa ở phía trên để dùng 'anh_daidien'.
        if ($song->anh_daidien && Storage::disk('public')->exists($song->anh_daidien)) {
            Storage::disk('public')->delete($song->anh_daidien);
        }

        $song->delete();

        return redirect()->route('admin.songs.index')->with('success', 'Xóa bài hát thành công!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $songs = Song::where('tenbaihat', 'like', "%{$query}%") // Tìm kiếm theo tên bài hát
        ->orWhereHas('artist', function($q) use ($query) {
            $q->where('name_artist', 'like', "%{$query}%"); // SỬA Ở ĐÂY: Dùng 'name_artist' thay vì 'name'
        })
            ->get();

        return view('admin.songs.index', compact('songs'));
    }
    // User
    public function indexuser()
    {
        // Bạn chưa lấy dữ liệu user ở đây.
        $this->data['users'] = User::all();
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
