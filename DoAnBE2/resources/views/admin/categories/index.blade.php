<!-- resources/views/admin/categories/index.blade.php -->
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

        .add-btn {
            margin-bottom: 15px;
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
        }

        .form-control {
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .d-flex {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .category-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <main>
            @include('admin.partials.header')

            <div>
                <h2 class="title">Quản lý thể loại</h2>
            </div>

            <section class="category-list">
                <div class="category-list-header">
                    <h2 class="title">Danh sách thể loại</h2>
                    <div class="add-btn">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">+ Thêm mới</a>
                    </div>
                </div>

                {{-- Form tìm kiếm --}}
                <form action="{{ route('admin.categories.search') }}" method="GET" class="d-flex mb-3">
                    <input 
                        type="text" 
                        name="query" 
                        placeholder="Tìm kiếm thể loại ..." 
                        value="{{ request('query') }}" 
                        class="form-control"
                        style="width: 300px;"
                    >
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Xóa bộ lọc</a>
                </form>

                {{-- Bảng danh sách thể loại --}}
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên thể loại</th>
                            <th>Nhóm</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="category-list-container">
                        @foreach($categories as $category)
                            <tr class="category-item-js">
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->tentheloai }}</td>
                                <td>{{ $category->nhom }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">Sửa</a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div id="pagination-controls" style="margin-top: 15px;"></div>
            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/category-pagination.js') }}"></script>
</body>
</html>
