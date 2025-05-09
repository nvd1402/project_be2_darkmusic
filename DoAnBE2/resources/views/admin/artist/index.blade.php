<!DOCTYPE html>
<html lang="en">
<head>@include('admin.partials.head')</head>
<body>
    <div class="container">
     <!--include file sidebar-->
     @include('admin.partials.sidebar')
    <!-- phân chính -->
    <main>
        <!--include file header-->
    @include('admin.partials.header')

        <!--content-->
        <div>
            <h2 class="title">Quản lý nghệ sĩ</h2>
        </div>
        <section class="song-list">
            <h2 class="title" style="margin-top: -50px">Danh sách người dùng</h2>

            <form action="" method="get">
                <div class="search-artist">
                    <label for="search" style="margin-right: 10px">Tìm kiếm</label>
                    <img src="" alt="">
                    <input name="search_artist" type="text" id="search" placeholder="Search...">
                    <button>Search</button>
                </div>
            </form>
            <div class="add-btn">
                    <a href="{{ route('admin.artist.create') }}">Thêm mới</a>
            </div>

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
                        @if (Storage::disk('public')->exists('public/artists/' . $artist->image_artist))
                            <img src="{{ asset('storage/public/artists/' . $artist->image_artist) }}" width="50" >
                        @else
                            <p>Ảnh không tồn tại</p>
                        @endif
                        </td>
                        <td>{{ $artist->name_artist }}</td>
                        <td>{{ $artist->category->tentheloai ?? 'Không có danh mục' }}</td>
                        <td><a href={{ route('admin.artist.update',['id'=> $artist->id]) }} class="btn edit">Sửa</a> |
                            <a href={{ route('admin.artist.delete',['id' => $artist->id]) }} class="btn delete">Xoá</a> </td>
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
