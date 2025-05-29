<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Category;
use App\Models\Userss;
use App\Models\News;
use App\Models\Ad;
use App\Models\Album;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public $data = [];
    public function index()
    {
        $songs = Song::with(['artist', 'category'])->get();

        $user = auth()->user();
        $userLikedSongIds = $user ? $user->likedSongs->pluck('id')->toArray() : [];

        return view('frontend.song', compact('songs', 'userLikedSongIds'));
    }
    public function showLikedSongs()
    {
        $user = auth()->user();  // hoặc lấy user bằng cách khác

        if (!$user) {
            return redirect()->route('login');  // hoặc xử lý khi chưa đăng nhập
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




    // Dashboard
    public function adminindex()
    {
        $soLuongBaiHat = Song::count();
        $this->data['soLuongBaiHat'] = $soLuongBaiHat;
$this->data['soLuongAlbum'] = Album::count();

        
        $this->data['soLuongComment'] = Comment::count();
        $this->data['soLuongTheLoai'] = Category::count();
     
        $this->data['soLuongTinTuc'] = News::count();

return view('admin.dashboard', $this->data);

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
        // Thay đổi dòng này để phân trang
        $this->data['songs'] = Song::paginate(7);  // Lấy 7 bài hát mỗi trang
        return view('admin.songs.index', $this->data);
    }


    public function editsong($id)
    {
        $this->data['song'] = Song::findOrFail($id);
        $this->data['categories'] = Category::all();
        $this->data['artists'] = Artist::all();
        return view('admin.songs.edit', $this->data);
    }


    public function updatesong(Request $request, $id)
    {
        $validated = $request->validate([
            'tenbaihat' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s]+$/u'],
            'nghesi' => 'required|exists:artists,id',
            'theloai' => 'required|exists:categories,id',
            'file_amthanh' => 'nullable|file|mimes:mp3,wav,ogg',
            'anh_daidien' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        $song = Song::findOrFail($id);
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
    }

    public function deletesong($id)
    {
        $song = Song::findOrFail($id);

        if ($song->file_amthanh && Storage::disk('public')->exists($song->file_amthanh)) {
            Storage::disk('public')->delete($song->file_amthanh);
        }

        if ($song->anh_daidien && Storage::disk('public')->exists($song->anh_daidien)) {
            Storage::disk('public')->delete($song->anh_daidien);
        }

        $song->delete();

        return redirect()->route('admin.songs.index')->with('success', 'Xóa bài hát thành công!');
    }

    // User
    public function indexuser()
    {
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
