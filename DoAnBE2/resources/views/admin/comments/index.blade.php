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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px 12px;
            text-align: center;
            vertical-align: middle;
        }

        table img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            display: block;
            margin: 0 auto 5px;
        }

        .text-left {
            text-align: left;
        }

        form.inline {
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <main>
            @include('admin.partials.header')

            <div class="page-header">
                <h2 class="title">Quản lý bình luận</h2>
            </div>

            <section class="comments-list">
                {{-- Tìm kiếm --}}
                <form action="{{ route('admin.comments.search') }}" method="GET" class="mb-3">
                    <input 
                        type="text" 
                        name="query" 
                        placeholder="Tìm kiếm nội dung bình luận hoặc tên người dùng..." 
                        value="{{ request('query') }}" 
                        class="form-control" 
                        style="width: 350px; display: inline-block;"
                    >
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">Xóa bộ lọc</a>
                </form>

                <a href="{{ route('admin.comments.create') }}" class="btn btn-success mb-3">Thêm bình luận mới</a>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:5%;">ID</th>
                            <th style="width:15%;">Người bình luận</th>
                            <th style="width:30%;">Nội dung bình luận</th>
                            <th style="width:25%;">Tin tức liên quan</th>
                            <th style="width:15%;">Ngày tạo</th>
                            <th style="width:10%;">Thao tác</th>
                        </tr>
                    </thead>
                 <tbody id="comments-list-container">
    @forelse ($comments as $comment)
        <tr class="comment-item-js">
            <td>{{ $comment->id }}</td>
            <td>
                @if($comment->user && $comment->user->avatar)
                    <img src="{{ asset('storage/' . $comment->user->avatar) }}" alt="Avatar">
                @endif
                <div>{{ $comment->user ? $comment->user->username : 'Người dùng đã xóa' }}</div>
            </td>
            <td class="text-left">{{ \Illuminate\Support\Str::limit($comment->noidung, 80) }}</td>
            <td>
                @if($comment->news)
                    <a href="{{ route('admin.news.edit', $comment->news->id) }}" target="_blank">{{ $comment->news->tieude }}</a>
                @else
                    <span>Tin tức đã xóa</span>
                @endif
            </td>
            <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <a href="{{ route('admin.comments.edit', $comment->id) }}" class="btn btn-warning btn-sm mb-1">Sửa</a>
                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center">Chưa có bình luận nào.</td></tr>
    @endforelse
</tbody>

                </table>

                <div id="pagination-controls" style="margin-top: 15px;">
                   
                </div>
              

            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/comment-pagination.js') }}"></script>
</body>
</html>
