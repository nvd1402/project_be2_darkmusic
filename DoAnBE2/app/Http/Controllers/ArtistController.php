<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    public function indexArtist()
    {
        $artists = Artist::with('category')->get();
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
<<<<<<< Updated upstream
            'name_artist' => 'required|min:4|max:50|string',
            'image_artist' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
=======
            'name_artist' => 'required|min:3|max:50|string',
            'image_artist' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
>>>>>>> Stashed changes
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
        $artist = Artist::find($artist_id);
        $categories = Category::all();

        return view('admin.artist.update', [
            'artist' => $artist,
            'categories' => $categories
        ]);
    }
    public function postUpdateArtist(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:artists,id',
            'name_artist' => 'required|min:3|max:50|string',
            'image_artist' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $artist = Artist::findOrFail($request->id);

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
        $artist = Artist::findOrFail($artist_id);

        if ($artist->image_artist && Storage::disk('public')->exists('artists/' . $artist->image_artist)) {
            Storage::disk('public')->delete('artists/' . $artist->image_artist);
        }

        $artist->delete();

        return redirect()->route('admin.artist.index')->with('success', 'Xoá thành công');
    }
}
