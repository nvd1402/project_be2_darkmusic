<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Category;
use Illuminate\Http\Request;

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
            'name_artist' => 'required|min:3|max:50|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        $data = $request->all();
        $check = Artist::create([
            'name_artist' => $data['name_artist'],
            'category_id' => $data['category_id']
        ]);

        return redirect()->route('admin.artist.index')->with('Đăng ký thành công!');
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
        $input = $request->all();

        $request->validate([
            'name_artist' => 'required|min:3|max:50|string',
            'category_id' => 'required',
        ]);

        $artist = Artist::find($input['id']);
        $artist->name_artist = $input['name_artist'];
        $artist->category_id = $input['category_id'];
        $artist->save();

        return redirect()->route('admin.artist.index')->with('success', 'Đã cập nhật thành công!');;
    }

    public function deleteArtist(Request $request)
    {
        $artist_id = $request->get('id');
        $artist = Artist::destroy($artist_id);

        return redirect()->route('admin.artist.index')->withSuccess('Xoá thành công');
    }
}
