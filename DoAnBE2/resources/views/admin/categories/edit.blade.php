<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
    <style>
        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
        }

        input[type="text"],
        select,
        textarea {
            width: 300px;
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-top: 5px;
            font-size: 14px;
            font-family: inherit;
        }

        textarea {
            resize: vertical;
        }

        .text-danger {
            color: #dc3545;
            margin-top: 5px;
            font-size: 13px;
        }

        button[type="submit"] {
            margin-top: 20px;
            padding: 8px 20px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }

        .category-image-preview {
            margin-top: 10px;
            width: 100px;
            height: auto;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <main>
            @include('admin.partials.header')

            <div>
                <h2 class="title">Chỉnh sửa thể loại</h2>
            </div>

            <section class="category-form">
                <h3>Chỉnh sửa thể loại</h3>
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label for="tentheloai">Tên thể loại</label>
                    <input type="text" name="tentheloai" id="tentheloai" value="{{ old('tentheloai', $category->tentheloai) }}" placeholder="Nhập tên thể loại" required>
                    @if ($errors->has('tentheloai'))
                        <div class="text-danger">{{ $errors->first('tentheloai') }}</div>
                    @endif

                    <label for="nhom">Nhóm</label>
                    <select name="nhom" id="nhom" required>
                        <option value="">-- Chọn nhóm --</option>
                        <option value="Nhạc Rock" {{ old('nhom', $category->nhom) == 'Nhạc Rock' ? 'selected' : '' }}>Nhạc Rock</option>
                        <option value="Nhạc Remix" {{ old('nhom', $category->nhom) == 'Nhạc Remix' ? 'selected' : '' }}>Nhạc Remix</option>
                        <option value="Nhạc Nổi Bật" {{ old('nhom', $category->nhom) == 'Nhạc Nổi Bật' ? 'selected' : '' }}>Nhạc Nổi Bật</option>
                        <option value="Nhạc Mới" {{ old('nhom', $category->nhom) == 'Nhạc Mới' ? 'selected' : '' }}>Nhạc Mới</option>
                    </select>
                    @if ($errors->has('nhom'))
                        <div class="text-danger">{{ $errors->first('nhom') }}</div>
                    @endif

                    <label for="description">Mô tả thể loại</label>
                    <textarea name="description" id="description" rows="4" placeholder="Nhập mô tả">{{ old('description', $category->description) }}</textarea>
                    @if ($errors->has('description'))
                        <div class="text-danger">{{ $errors->first('description') }}</div>
                    @endif

<label for="status">Trạng thái hoạt động</label>
<select name="status" id="status" required>
    <option value="1" {{ old('status', $category->status ?? 1) == 1 ? 'selected' : '' }}>Hoạt động</option>
    <option value="0" {{ old('status', $category->status ?? 1) == 0 ? 'selected' : '' }}>Không hoạt động</option>
</select>
@if ($errors->has('status'))
    <div class="text-danger">{{ $errors->first('status') }}</div>
@endif


                    <label for="image">Ảnh đại diện (nếu muốn thay đổi)</label><br>
                    @if($category->image)
                        @php
                            $imagePath = $category->image;
                            if (!str_starts_with($imagePath, 'category/')) {
                                $imagePath = 'category/' . $imagePath;
                            }
                        @endphp
                        <img src="{{ asset('storage/' . $imagePath) }}" alt="Ảnh thể loại" class="category-image-preview">
                    @else
                        <p>Chưa có ảnh đại diện</p>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*">
                    @if ($errors->has('image'))
                        <div class="text-danger">{{ $errors->first('image') }}</div>
                    @endif

                    <button type="submit">Cập nhật</button>
                </form>
            </section>

        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
