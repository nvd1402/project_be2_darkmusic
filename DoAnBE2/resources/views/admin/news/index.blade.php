<!-- resources/views/admin/news/index.blade.php -->

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
                <h2 class="title">Danh sách tin tức</h2>
            </div>



            <section class="news-list">

                <table>
                <div class="add-btn">
                <a href="{{ route('admin.news.create') }}" class="btn add-new">Thêm tin tức mới</a>
            </div>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tiêu đề</th>
                            <th>Nội dung</th> <!-- Cột Nội dung -->
                            <th>Hình ảnh</th> <!-- Cột Hình ảnh -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->tieude }}</td>
                                <td>{{ Str::limit($item->noidung, 50) }} <!-- Hiển thị nội dung ngắn gọn (50 ký tự) -->
                                </td>
                                <td>
                                    <!-- Hiển thị hình ảnh nếu có -->
                                    @if ($item->hinhanh)
                                        <img src="{{ asset('storage/' . $item->hinhanh) }}" alt="Hình ảnh tin tức" width="100" height="100">
                                    @else
                                        <span>Không có hình ảnh</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.news.edit', $item->id) }}" class="btn edit">Sửa</a>
                                    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn delete" onclick="return confirm('Bạn có chắc chắn muốn xóa tin này?')">Xóa</button>
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
