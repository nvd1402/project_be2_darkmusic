<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ArtistController extends Controller
{
    public function indexArtist()
    {
        $artists = Artist::with('category')->get();
        if ($artists->isEmpty()) {
            abort(404);
        }
        return view('admin.artist.index', ['artists' => $artists]);
    }
    public function createArtist()
    {
        $categories = Category::all();
        return view('admin.artist.create', compact('categories'));
    }

    public function postArtist(Request $request)
    {
        $request->validate([
            'name_artist' => 'required|min:4|max:50|string',
            'image_artist' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'category_id' => 'required|exists:categories,id'
        ]);

        $fileName = null;

        if ($request->hasFile('image_artist')) {
            $file = $request->file('image_artist');
            $fileName = $file->hashName();
            $file->store('artists', 'public');
        }


        $data = $request->all();
        Artist::create([
            'name_artist' => $data['name_artist'],
            'image_artist' => $fileName,
            'category_id' => $data['category_id']
        ]);

        return redirect()->route('admin.artist.index')->with('Tạo Artist thành công!');
    }

    public function updateArtist(Request $request)
    {
        $artist_id = $request->get('id');

        try {
            $artist = Artist::findOrFail($artist_id);
            $categories = Category::all();

            return view('admin.artist.update', [
                'artist' => $artist,
                'categories' => $categories
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Nghệ sĩ không tồn tại hoặc đã bị xoá.');
        }
    }
    public function postUpdateArtist(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:artists,id',
            'name_artist' => 'required|min:3|max:50|string',
            'image_artist' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'category_id' => 'exists:categories,id',
            'original_updated_at' => 'required|date',
        ], [
            'name_artist.required' => 'Tên nghệ sĩ là bắt buộc',
            'name_artist.min' => 'Tên nghệ sĩ tối thiểu 3 ký tự',
            'name_artist.max' => 'Tên nghệ sĩ tối đa 50 ký tự',
            'image_artist.image' => 'Ảnh không đúng định dạng',
            'image_artist.mimes' => 'Ảnh chỉ được jpg, png, jpeg, gif',
            'image_artist.max' => 'Kích thước ảnh không được vượt quá 2MB',
            'category_id.exists' => 'Thể loại không tồn tại',
        ]);

        $artist = Artist::findOrFail($request->id);

        if ($artist->updated_at->ne(Carbon::parse($request->original_updated_at))) {
            return redirect()->back()
                ->with('error', 'Nội dung nghệ sĩ này đã bị người khác thay đổi. Vui lòng tải lại trang để xem phiên bản mới nhất.')
                ->withInput();
        }

        $fileName = null;
        if ($request->hasFile('image_artist')) {
            if ($artist->image_artist && Storage::disk('public')->exists('artists/' . $artist->image_artist)) {
                Storage::disk('public')->delete('artists/' . $artist->image_artist);
            }

            $file = $request->file('image_artist');
            $fileName = $file->hashName();
            $file->store('artists', 'public');
        }

        $artist->update([
            'name_artist' => $request->name_artist,
            'image_artist' => $fileName,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.artist.index')->with('success', 'Đã cập nhật thành công!');
    }

    public function deleteArtist(Request $request)
    {
        $artist_id = $request->get('id');

        try {
            $artist = Artist::findOrFail($artist_id);

            if ($artist->image_artist && Storage::disk('public')->exists('artists/' . $artist->image_artist)) {
                Storage::disk('public')->delete('artists/' . $artist->image_artist);
            }

            $artist->delete();

            return redirect()->route('admin.artist.index')->with('success', 'Xoá nghệ sĩ thành công');
        } catch (ModelNotFoundException $e) {
            abort(404);
        } catch (\Exception $e) {
            abort(500, 'Đã xảy ra lỗi khi xoá nghệ sĩ');
        }
    }
}
