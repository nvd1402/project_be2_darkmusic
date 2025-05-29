<!-- resources/views/admin/news/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.partials.head')
    <style>
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-primary { background-color: #007bff; }
        .btn-secondary { background-color: #6c757d; }
        .btn-success { background-color: #28a745; }
        .btn-warning { background-color: #ffc107; color: #000; }
        .btn-danger { background-color: #dc3545; }
        .btn:hover { opacity: 0.85; }
    </style>
</head>
<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <main>
            @include('admin.partials.header')

            <div class="page-header">
                <h2 class="title">Danh sách tin tức</h2>
            </div>

            {{-- Thông báo flash --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="news-list">
                <form action="{{ route('admin.news.search') }}" method="GET" class="mb-3">
                    <input 
                        type="text" 
                        name="query" 
                        placeholder="Tìm kiếm tiêu đề hoặc đơn vị đăng..." 
                        value="{{ request('query') }}" 
                        class="form-control" 
                        style="width: 300px; display: inline-block;"
                    >
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Xóa bộ lọc</a>
                </form>

                <div class="add-btn mb-3">
                    <a href="{{ route('admin.news.create') }}" class="btn btn-success">Thêm tin tức mới</a>
                </div>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 25%;">Tiêu đề</th>
                            <th style="width: 35%;">Nội dung</th>
                            <th style="width: 15%;">Hình ảnh</th>
                            <th style="width: 20%;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="news-table-body">
                        @forelse ($news as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->tieude }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($item->noidung, 50) }}</td>
                                <td>
                                    @if ($item->hinhanh)
                                        @php
                                            $hinhanh = $item->hinhanh;
                                            if (!str_starts_with($hinhanh, 'news_images/')) {
                                                $hinhanh = 'news_images/' . $hinhanh;
                                            }
                                        @endphp
                                        <img src="{{ asset('storage/' . $hinhanh) }}" alt="Hình ảnh tin tức" width="100" height="100">

                                        
                                    @else
                                        <span>Không có hình ảnh</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                    <form 
                                        action="{{ route('admin.news.destroy', $item->id) }}" 
                                        method="POST" 
                                        style="display:inline-block;" 
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa tin này?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Chưa có tin tức nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div id="pagination-controls" style="margin-top: 15px;"></div>
            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/new-pagination.js') }}"></script>
</body>
</html>