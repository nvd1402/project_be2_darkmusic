<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Category;
use App\Models\Userss; // Có vẻ như đây là một Model không chuẩn, hãy kiểm tra lại tên Model User của bạn
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Đảm bảo đã import này

class AdminController extends Controller
{
    public $data = [];

    // Dashboard
    public function adminindex()
    {
        $soLuongBaiHat = Song::count();
        $this->data['soLuongBaiHat'] = $soLuongBaiHat;
        return view('admin.dashboard', $this->data);
    }

    // Song CRUD Operations
    public function createsong()
    {
        $this->data['categories'] = Category::all();
        $this->data['artists'] = Artist::all();
        return view('admin.songs.create', $this->data);
    }

    public function storesong(Request $request)
    {
        $validated = $request->validate([
            'tenbaihat' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\p{L}\p{M}\d\s\-\'\.]+$/u'
            ],
            'nghesi' => 'required|exists:artists,id',
            'theloai' => 'required|exists:categories,id',
            'file_amthanh' => 'required|file|mimes:mp3,wav,ogg',
            'anh_daidien' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $song = new Song();
        $song->tenbaihat = $validated['tenbaihat'];
        $song->nghesi = $validated['nghesi'];
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
        $this->data['songs'] = Song::paginate(7);
        return view('admin.songs.index', $this->data);
    }

    public function editsong($id)
    {
        try {
            $this->data['song'] = Song::findOrFail($id); // Bắt ModelNotFoundException ở đây
            $this->data['categories'] = Category::all();
            $this->data['artists'] = Artist::all();
            return view('admin.songs.edit', $this->data);
        } catch (ModelNotFoundException $e) {
            // Nếu không tìm thấy bài hát, chuyển hướng về trang index với thông báo
            return redirect()->route('admin.songs.index')
                ->with('info', 'Bài hát bạn muốn chỉnh sửa không tồn tại hoặc đã bị xóa.');
        }
    }


    public function updatesong(Request $request, $id)
    {
        try {
            $song = Song::findOrFail($id); // Bắt ModelNotFoundException ở đây

            $validated = $request->validate([
                'tenbaihat' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\p{M}\d\s\-\'\.]+$/u'], // Đã sửa regex cho phép tiếng Việt và dấu câu cơ bản
                'nghesi' => 'required|exists:artists,id',
                'theloai' => 'required|exists:categories,id',
                'file_amthanh' => 'nullable|file|mimes:mp3,wav,ogg',
                'anh_daidien' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);

            $song->tenbaihat = $validated['tenbaihat'];
            $song->nghesi = $validated['nghesi'];
            $song->theloai = $validated['theloai'];

            if ($request->hasFile('file_amthanh')) {
                if ($song->file_amthanh && Storage::disk('public')->exists($song->file_amthanh)) {
                    Storage::disk('public')->delete($song->file_amthanh);
                }
                $song->file_amthanh = $request->file('file_amthanh')->store('songs/audio', 'public');
            }

            if ($request->hasFile('anh_daidien')) {
                if ($song->anh_daidien && Storage::disk('public')->exists($song->anh_daidien)) {
                    Storage::disk('public')->delete($song->anh_daidien);
                }
                $song->anh_daidien = $request->file('anh_daidien')->store('songs/images', 'public');
            }

            $song->save();

            return redirect()->route('admin.songs.index')->with('success', 'Cập nhật bài hát thành công!');

        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.songs.index')
                ->with('info', 'Bài hát bạn muốn cập nhật không tồn tại hoặc đã bị xóa.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không mong muốn khi cập nhật bài hát. Vui lòng thử lại.');
        }
    }


    public function deletesong($id)
    {
        try {
            $song = Song::findOrFail($id); // Bắt ModelNotFoundException ở đây

            if ($song->file_amthanh && Storage::disk('public')->exists($song->file_amthanh)) {
                Storage::disk('public')->delete($song->file_amthanh);
            }

            if ($song->anh_daidien && Storage::disk('public')->exists($song->anh_daidien)) {
                Storage::disk('public')->delete($song->anh_daidien);
            }

            $song->delete();

            return redirect()->route('admin.songs.index')->with('success', 'Xóa bài hát thành công!');

        } catch (ModelNotFoundException $e) {
            // Nếu bài hát không tìm thấy (có thể đã bị xóa ở tab khác)
            return redirect()->route('admin.songs.index')
                ->with('info', 'Bài hát này đã được xóa hoặc không còn tồn tại trên hệ thống.');
        } catch (\Exception $e) {
            // Xử lý các lỗi chung khác
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không mong muốn khi xóa bài hát. Vui lòng thử lại.');
        }
    }

    // User Management
    public function indexuser()
    {
        $this->data['users'] = User::all(); // Sử dụng User Model chính xác
        return view('admin.users.index', $this->data);
    }

    public function createuser()
    {
        return view('admin.users.create', $this->data);
    }

    public function edituser($id)
    {
        try {
            $this->data['user'] = User::findOrFail($id);
            return view('admin.users.edit', $this->data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.users.index')
                ->with('info', 'Người dùng bạn muốn chỉnh sửa không tồn tại hoặc đã bị xóa.');
        }
    }

    // Revenue
    public function revenue()
    {
        return view('admin.revenue.index', $this->data);
    }

    // Các phương thức khác của bạn từ frontend (tạm thời giữ nguyên hoặc di chuyển sang HomeController nếu chúng chỉ dùng cho frontend)
    public function index()
    {
        $songs = Song::with(['artist', 'category'])->get();

        $user = auth()->user();
        $userLikedSongIds = $user ? $user->likedSongs->pluck('id')->toArray() : [];

        return view('frontend.song', compact('songs', 'userLikedSongIds'));
    }
    public function showLikedSongs()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $likedSongs = $user->likedSongs()->get();

        return view('liked_songs', compact('likedSongs'));
    }
    public function toggleLike($id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $action = request('action');

        if ($action === 'like') {
            $user->likedSongs()->syncWithoutDetaching([$id]);
        } elseif ($action === 'unlike') {
            $user->likedSongs()->detach($id);
        }

        return response()->json(['message' => 'Thành công']);
    }

}
