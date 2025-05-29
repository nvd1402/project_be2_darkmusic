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
            vertical-align: middle;
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

        /* Style ảnh đại diện */
        .category-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        form.inline-form {
            display: inline-block;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <main>
            @include('admin.partials.header')
            @if ($errors->any())
    <div style="background-color: #f8d7da; color: #842029; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div style="background-color: #d1e7dd; color: #0f5132; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif


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
            <th>Ảnh</th>
            <th>Tên thể loại</th>
            <th>Nhóm</th>
            <th>Mô tả</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody id="category-list-container">
        @foreach($categories as $category)
            <tr class="category-item-js">
                <td>{{ $category->id }}</td>
   <td>
    @if ($category->image)
        @php
            $image = $category->image;
            if (!str_starts_with($image, 'category/')) {
                $image = 'category/' . $image;
            }
        @endphp
        <img src="{{ asset('storage/' . $image) }}" alt="{{ $category->tentheloai }}" width="100" height="100">
    @else
        <span>Chưa có ảnh</span>
    @endif
</td>
                <td>{{ $category->tentheloai }}</td>
                <td>{{ $category->nhom }}</td>
                <td>{{ Str::limit($category->description, 50) }}</td>
                <td>
                    @if ($category->status)
                        <span style="color: green;">Hoạt động</span>
                    @else
                        <span style="color: red;">Không hoạt động</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">Sửa</a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                        @csrf
                        @method('DELETE')
                         <input type="hidden" name="updated_at" value="{{ $category->updated_at }}">
                        <button type="submit" class="btn btn-danger">Xóa</button>
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
