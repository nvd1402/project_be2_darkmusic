<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function indexArtist()
    {
        $artists = Artist::all();
        return view('admin.artist.index', ['artists' => $artists]);
    }
    public function createArtist()
    {
        return view('admin.artist.create');
    }
    public function postArtist(Request $request)
    {
        $request->validate([
            'name_artist' => 'required|min:3|max:50|string',
            'name_genre' => 'required'
        ]);

        $data = $request->all();
        $check = Artist::create([
            'name_artist' => $data['name_artist'],
            'genre' => $data['name_genre']
        ]);

        return redirect()->route('admin.artist.index')->with('Đăng ký thành công!');
    }

    public function updateArtist(Request $request)
    {
        $artist_id = $request->get('id');
        $artist = Artist::find($artist_id);

        return view('admin.artist.update', ['artist' => $artist]);
    }
    public function postUpdateArtist(Request $request)
    {
        $input = $request->all();

        $request->validate([
            'name_artist' => 'required|min:3|max:50|string',
            'name_genre' => 'required',
        ]);

        $artist = Artist::find($input['id']);
        $artist->name_artist = $input['name_artist'];
        $artist->genre = $input['name_genre'];
        $artist->save();

        return redirect()->route('admin.artist.index');
    }

    public function deleteArtist(Request $request)
    {
        $artist_id = $request->get('id');
        $artist = Artist::destroy($artist_id);

        return redirect()->route('admin.artist.index')->withSuccess('Xoá thành công');
    }
}
