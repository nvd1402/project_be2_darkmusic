<!-- resources/views/admin/categories/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <main>
            <!-- include file header -->
            @include('admin.partials.header')

            <!-- Content -->
            <div>
                <h2 class="title">Quản lý thể loại</h2>
            </div>

            <section class="category-list">
                <div class="category-list-header">
                    <h2 class="title">Danh sách thể loại</h2>
                    <div class="add-btn">
                        <a href="{{ route('admin.categories.create') }}">Thêm mới</a>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên thể loại</th>
                            <th>Nhóm</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->tentheloai }}</td>
                            <td>{{ $category->nhom }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category->id) }}">Sửa</a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Bạn có chắc chắn?')">Xóa</button>
                                </form>
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
