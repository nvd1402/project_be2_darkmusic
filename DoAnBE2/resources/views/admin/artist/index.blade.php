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


            <div class="add-btn">
                <a href="{{ route('admin.artist.create') }}">Thêm mới</a>
            </div>

            <table class="song-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên nghệ sĩ</th>
                    <th>Thể loại âm nhạc</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($artists as $artist)
                    <tr>
                        <td>{{ $artist->id }}</td>
                        <td>{{ $artist->name_artist }}</td>
                        <td>{{ $artist->category->tentheloai ?? 'Không có danh mục' }}</td>
                        <td><a href={{ route('admin.artist.update',['id'=> $artist->id]) }} class="link--artist">Sửa</a> |
                            <a href={{ route('admin.artist.delete',['id' => $artist->id]) }} class="link--artist">Xoá</a> </td>
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
