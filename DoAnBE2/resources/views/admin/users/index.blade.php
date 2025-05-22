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
        @include('admin.users.search')


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
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->user_id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td><img class="avatar" src="{{ asset('storage/' . $user->avatar) }}" alt="avatar"></td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', ['id' => $user->user_id]) }}" class="btn edit">Sửa</a>

                            <!-- Form xác nhận xóa -->
                            <form action="{{ route('admin.users.destroy', ['id' => $user->user_id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn delete" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">Xóa</button>


                            </form>

                            <span class="status {{ $user->status }}">
        {{ $user->status == 'active' ? 'Hoạt động' : 'Vô hiệu hóa' }}
    </span>
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
