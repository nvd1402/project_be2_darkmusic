<div>
    <div class="search-artist">
        <input type="text" wire:model.live.debounce.500ms="query" placeholder="Nhập tên nghệ sĩ..." class="search_query">
    </div>

    <div id="song-table-container">
    <table class="song-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Ảnh nghệ sĩ</th>
                    <th>Tên nghệ sĩ</th>
                    <th>Thể loại âm nhạc</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($artists as $artist)
                    <tr>
                        <td>{{ $artist->id }}</td>
                        <td>
                        @if (Storage::disk('public')->exists('artists/' . $artist->image_artist))
                            <img src="{{ asset('storage/artists/' . $artist->image_artist) }}" width="50" >
                        @else
                            <p>Ảnh không tồn tại</p>
                        @endif
                        </td>
                        <td>{{ $artist->name_artist }}</td>
                        <td>{{ $artist->category->tentheloai ?? 'Không có danh mục' }}</td>
                        <td><a href={{ route('admin.artist.update',['id'=> $artist->id]) }} class="btn edit" >Sửa</a> |
                            <a href={{ route('admin.artist.delete',['id' => $artist->id]) }} class="btn delete"  onclick="return confirm('Bạn có chắc chắn muốn xoá nghệ sĩ này không?')">Xoá</a> </td>
                    </tr>
                @endforeach 
                </tbody>
            </table>
    </div>
    <div >
        {{ $artists->links() }}
    </div>
</div>