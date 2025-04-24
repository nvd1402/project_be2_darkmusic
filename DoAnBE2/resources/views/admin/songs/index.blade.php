<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body>

<div class="container">
    @include('admin.partials.sidebar')

    <main>
        <!--include file header-->
        @include('admin.partials.header')
        @include('admin.songs.search')

        <!--content-->
        <div>
            <h2 class="title">Quản lý bài hát</h2>
        </div>
        <section class="song-list">
            <h2 class="title" style="margin-top: -50px">Danh sách bài hát</h2>
            <div class="add-btn">
                <a href="{{ route('admin.songs.create') }}">Thêm mới</a>
            </div>

            <table class="song-table">
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
                        <td>{{ $song->nghesi }}</td>
                        <td>{{ $song->theloai }}</td>
                        <td>
                            @if($song->anh_daidien)
                                <img src="{{ asset('storage/' . $song->anh_daidien) }}" width="50" alt="images">
                            @else
                                Không có ảnh
                            @endif
                        </td>
                        <td>
                            @if($song->file_amthanh)
                                <audio controls>
                                    <source src="{{ asset('storage/'.$song->file_amthanh) }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            @else
                                <p>Không có âm thanh</p>
                            @endif
                        </td>
                        <td>
                            <!-- Sửa -->
                            <a href="{{ route('admin.songs.edit', $song->id) }}" class="btn edit">Sửa</a>

                            <!-- Xóa -->
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
        </section>
    </main>
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
