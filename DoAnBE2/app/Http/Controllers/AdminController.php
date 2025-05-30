<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Album;
use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AdminController extends Controller
{
    public $data = [];

    // Dashboard
    public function adminindex()
    {
        $soluongnghesi = Artist::count();
        $soluongalbum = Album::count();
        $soluongcomment = Comment::count();
        $soluongtintuc = News::count();
        $soluongtheloai = Category::count();
        $soluongnguoidung = User::count();
        $soluongquangcao = Ad::count();
        $soLuongBaiHat = Song::count();
        $this->data['soLuongBaiHat'] = $soLuongBaiHat;
        $this->data['soluongnguoidung'] = $soluongnguoidung;
        $this->data['soluongquangcao'] = $soluongquangcao;
        $this->data['soluongtheloai'] = $soluongtheloai;
        $this->data['soluongtintuc'] = $soluongtintuc;
        $this->data['soluongcomment'] = $soluongcomment;
        $this->data['soluongalbum'] = $soluongalbum;
        $this->data['soluongnghesi'] = $soluongnghesi;
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
        $cleanedTenBaiHat = preg_replace('/^\s+|\s+$/u', '', $request->input('tenbaihat'));
        $cleanedTenBaiHat = preg_replace('/\s+/u', ' ', $cleanedTenBaiHat);

        $request->merge([
            'tenbaihat' => $cleanedTenBaiHat
        ]);

        $validated = $request->validate([
            'tenbaihat' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\p{L}\p{M}\d\s\-\'\.]+$/u',
                'unique:songs,tenbaihat'
            ],
            'nghesi' => 'required|exists:artists,id',
            'theloai' => 'required|exists:categories,id',
            'file_amthanh' => 'required|file|mimes:mp3,wav,ogg|max:10240',
            'anh_daidien' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
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

    public function editsong(Request $request, $id)
    {
        try {
            $song = Song::findOrFail($id);

            $updatedAtFromList = $request->query('updated_at');

            if ($updatedAtFromList) {
                $formUpdatedAt = Carbon::parse($updatedAtFromList);
                $dbUpdatedAt = Carbon::parse($song->updated_at);

                if ($formUpdatedAt->ne($dbUpdatedAt)) {
                    return redirect()->route('admin.songs.index')
                        ->with('error', 'Bài hát bạn muốn chỉnh sửa đã được cập nhật bởi người dùng khác. Vui lòng tải lại trang để xem phiên bản mới nhất.');
                }
            }

            $this->data['song'] = $song;
            $this->data['categories'] = Category::all();
            $this->data['artists'] = Artist::all();
            return view('admin.songs.edit', $this->data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.songs.index')
                ->with('info', 'Bài hát bạn muốn chỉnh sửa không tồn tại hoặc đã bị xóa.');
        }
    }


    public function updatesong(Request $request, $id)
    {
        try {
            $song = Song::findOrFail($id);

            $formUpdatedAt = Carbon::parse($request->input('updated_at'));
            $dbUpdatedAt = Carbon::parse($song->updated_at);

            if ($formUpdatedAt->ne($dbUpdatedAt)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Bài hát đã được cập nhật bởi người dùng khác. Vui lòng tải lại trang và thử lại để xem phiên bản mới nhất.');
            }

            $cleanedTenBaiHat = preg_replace('/^\s+|\s+$/u', '', $request->input('tenbaihat'));
            $cleanedTenBaiHat = preg_replace('/\s+/u', ' ', $cleanedTenBaiHat);

            $request->merge([
                'tenbaihat' => $cleanedTenBaiHat
            ]);

            $validated = $request->validate([
                'tenbaihat' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\p{L}\p{M}\d\s\-\'\.]+$/u',
                    'unique:songs,tenbaihat,' . $song->id,
                ],
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
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error("Lỗi cập nhật bài hát: " . $e->getMessage() . " - File: " . $e->getFile() . " - Line: " . $e->getLine());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không mong muốn khi cập nhật bài hát. Vui lòng thử lại.');
        }
    }


    public function deletesong(Request $request, $id) // Thêm Request $request để nhận tham số updated_at
    {
        try {
            $song = Song::findOrFail($id);

            // BẮT ĐẦU PHẦN KIỂM TRA OPTIMISTIC LOCKING KHI XÓA
            // Lấy updated_at từ URL (khi người dùng click "Xóa" từ danh sách)
            $updatedAtFromList = $request->query('updated_at');

            if ($updatedAtFromList) { // Chỉ kiểm tra nếu updated_at được truyền
                $formUpdatedAt = Carbon::parse($updatedAtFromList);
                $dbUpdatedAt = Carbon::parse($song->updated_at);

                if ($formUpdatedAt->ne($dbUpdatedAt)) {
                    // Nếu updated_at khác nhau, tức là bản ghi đã được người khác cập nhật/xóa
                    return redirect()->route('admin.songs.index')
                        ->with('error', 'Bài hát đã được cập nhật bởi người dùng khác hoặc đã bị xóa. Vui lòng tải lại trang để xem dữ liệu mới nhất.');
                }
            }
            // KẾT THÚC PHẦN KIỂM TRA OPTIMISTIC LOCKING KHI XÓA

            if ($song->file_amthanh && Storage::disk('public')->exists($song->file_amthanh)) {
                Storage::disk('public')->delete($song->file_amthanh);
            }

            if ($song->anh_daidien && Storage::disk('public')->exists($song->anh_daidien)) {
                Storage::disk('public')->delete($song->anh_daidien);
            }

            $song->delete();

            return redirect()->route('admin.songs.index')->with('success', 'Xóa bài hát thành công!');

        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.songs.index')
                ->with('info', 'Bài hát này đã được xóa hoặc không còn tồn tại trên hệ thống.');
        } catch (\Exception $e) {
            \Log::error("Lỗi xóa bài hát: " . $e->getMessage() . " - File: " . $e->getFile() . " - Line: " . $e->getLine());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không mong muốn khi xóa bài hát. Vui lòng thử lại.');
        }
    }

    // User Management
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
