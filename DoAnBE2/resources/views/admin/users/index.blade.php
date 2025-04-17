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
            <h2 class="title">Quản lý người dùng</h2>
        </div>
        <section class="song-list">
            <h2 class="title" style="margin-top: -50px">Danh sách người dùng</h2>
            <div class="add-btn">
                <a href="{{ route('admin.users.create') }}">Thêm mới</a>
            </div>

            <table class="song-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Quyền hạn</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>NguyenVanA</td>
                    <td>a@gmail.com</td>
                    <td><img class="avatar" src="" alt="avatar"></td>
                    <td>Admin</td>
                    <td>
                        <a href="{{ route('admin.users.edit') }}" class="btn edit">Sửa</a>
                        <a href="#" class="btn delete">Xóa</a>
                        <span class="status active">Hoạt động</span>
                    </td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>NguyenVanB</td>
                    <td>b@gmail.com</td>
                    <td><img class="avatar" src="" alt="avatar"></td>
                    <td>Vip</td>
                    <td>
                        <a href="#" class="btn edit">Sửa</a>
                        <a href="#" class="btn delete">Xóa</a>
                        <span class="status active">Hoạt động</span>
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
