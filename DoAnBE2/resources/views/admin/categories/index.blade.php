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
                    <h2 class="title">Danh sách thể loại  </h2>
                    <div class="add-btn">
                        <a href="{{ route('categories.create') }}">Thêm mới</a>
                    </div>
                </div>

                <table class="category-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên thể loại</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->tentheloai }}</td>
                                <td>
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn edit">Sửa</a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn delete" onclick="return confirm('Bạn có chắc chắn muốn xóa thể loại này?')">Xóa</button>
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
