<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.partials.head')
    <style>
        main {
            overflow-y: auto; /* Cho phép cuộn nếu nội dung dài */
            height: 100vh; /* Chiều cao đầy đủ để cuộn */
        }
        /* Bạn có thể dần thay thế .btn sang Tailwind, hoặc giữ như hiện tại */
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
     margin-left: 1050px;
    margin-top: 38px;
}
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
            @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
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
                                        <input type="hidden" name="updated_at" value="{{ $item->updated_at->toDateTimeString() }}">
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

                {{-- Phân trang Laravel + Tailwind --}}
   <div class="mt-4 flex justify-center">
    {{ $news->links('pagination::tailwind') }}
</div>

            </section>
        </main>
    </div>
</body>
</html>
