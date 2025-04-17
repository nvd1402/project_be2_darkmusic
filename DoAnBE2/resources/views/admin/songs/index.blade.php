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
                <tr>
                    <td>1</td>
                    <td>Thiên Lý Ơi</td>
                    <td>Jack 97</td>
                    <td>Nhạc trẻ</td>
                    <td><img class="avatar" src="" alt="avatar"></td>
                    <td>thienlyoi.mp3</td>
                    <td>
                        <a href="{{ route('admin.songs.edit') }}" class="btn edit">Sửa</a>
                        <a href="#" class="btn delete">Xóa</a>
                        <span class="status active">Hoạt động</span>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Flower</td>
                    <td>Jisoo</td>
                    <td>Kpop</td>
                    <td><img class="avatar" src="" alt="avatar"></td>
                    <td>flower.mp3</td>
                    <td>
                        <a href="#" class="btn edit">Sửa</a>
                        <a href="#" class="btn delete">Xóa</a>
                        <span class="status disabled">Vô hiệu hóa</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>
    </main>
</div>

</div>



<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
