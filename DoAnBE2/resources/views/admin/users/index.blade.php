<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
    <style>
        nav[role="navigation"] ul {
            display: inline-flex !important;
            flex-direction: row !important;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }
        nav[role="navigation"] ul {
            gap: 0.5rem; /* khoảng cách giữa các số */
            /* hoặc dùng padding margin cho li */
        }

        nav[role="navigation"] ul > li {
            margin-left: 0.5rem; /* cách trái 0.5rem */
        }

        /* Nếu muốn bỏ khoảng cách âm mặc định của -space-x-px */
        nav[role="navigation"] ul {
            margin-left: 500px;
            margin-top: 38px;
        }
        .alert {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 1rem;
            box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
            max-width: 600px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert li {
            margin-bottom: 5px;
        }

    </style>
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

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
            <div class="mt-4 flex justify-center">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </section>
    </main>
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
