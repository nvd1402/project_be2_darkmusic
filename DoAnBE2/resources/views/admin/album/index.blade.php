<!-- resources/views/admin/album/index.blade.php -->

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
                <h2 class="title">Danh sách Album</h2>
            </div>

            <section class="album-list">

                <div class="add-btn">
                    <a href="{{ route('admin.album.create') }}" class="btn add-new">Thêm Album mới</a>
                </div>
  {{-- Form tìm kiếm --}}
                <form action="{{ route('admin.album.search') }}" method="GET" class="d-flex mb-3">
                    <input 
                        type="text" 
                        name="query" 
                        placeholder="Tìm kiếm tên album và nghệ sĩ ..." 
                        value="{{ request('query') }}" 
                        class="form-control"
                        style="width: 300px;"
                    >
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    <a href="{{ route('admin.album.index') }}" class="btn btn-secondary">Xóa bộ lọc</a>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên Album</th>
                            <th>Nghệ sĩ</th>
                            <th>Ảnh bìa</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                  <tbody id="album-list-container">
    @forelse ($albums as $album)
        <tr class="album-item-js"> <!-- THÊM class này -->
            <td>{{ $album->id }}</td>
            <td>{{ $album->ten_album }}</td>
            <td>{{ $album->nghe_si }}</td>
            <td>
                @if ($album->anh_bia && \Illuminate\Support\Facades\Storage::disk('public')->exists($album->anh_bia))
                    <img src="{{ asset('storage/' . $album->anh_bia) }}" alt="Ảnh bìa Album" width="100" height="100" />
                @else
                    <span>Không có ảnh</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.album.edit', $album->id) }}" class="btn edit">Sửa</a>
                <form action="{{ route('admin.album.destroy', $album->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn delete" onclick="return confirm('Bạn có chắc chắn muốn xóa album này?')">Xóa</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="5" style="text-align:center;">Chưa có album nào</td></tr>
    @endforelse
</tbody>

                </table>
                <div id="pagination-controls" style="margin-top: 15px; text-align: center;"></div>

            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/album-pagination.js') }}"></script>

</body>
</html>
