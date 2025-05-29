<div>
    <div class="search_query">
        <input type="text" wire:model.live.debounce.500ms="query" placeholder="Nhập tên bài hát..." class="search_query">
    </div>

    <div id="song-table-container"> <table class="song-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tên bài hát</th>
                <th>Nghệ sĩ</th>
                <th>Thể loại</th>
                <th>Avatar</th>
                <th>File âm thanh</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($songs as $song)
                <tr>
                    <td>{{ $song->id }}</td>
                    <td>{{ $song->tenbaihat }}</td>
                    <td>{{ $song->artist->name_artist}}</td>
                    <td>{{ $song->category ? $song->category->tentheloai : 'Không có thể loại' }}</td>
                    <td>
                        @if($song->anh_daidien)
                            <img src="{{ asset('storage/' . $song->anh_daidien) }}" width="50" alt="images">
                        @else
                            Không có ảnh
                        @endif
                    </td>
                    <td>
                        @if($song->file_amthanh)
                            <a style="margin-left: 40px"     href="{{ asset('storage/'.$song->file_amthanh) }}" target="_blank"> ▶ Play</a>
                        @else
                            <p>Không có âm thanh</p>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.songs.edit', $song->id) }}" class="btn edit">Sửa</a>
                        <form action="{{ route('admin.songs.destroy', $song->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn delete" onclick="return confirm('Bạn có chắc chắn muốn xóa bài hát này?')">Xóa</button>
                        </form>
                        <span class="status active">Hoạt động</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $songs->links() }}
    </div>
</div>
