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
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0069d9;
        }
    </style>
</head>

<body>
    <div class="container">
        @include('admin.partials.sidebar')

        <main>
            @include('admin.partials.header')

            <div>
                <h2 class="title">Thêm thể loại mới</h2>
            </div>

            <section class="category-form">
                <h3>Thêm thể loại</h3>
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <p>Lưu ý những trường có (*) là bắt buộc phải điền</p>

                    <label for="tentheloai">Tên thể loại (*)</label>
                    <input type="text" id="tentheloai" name="tentheloai" placeholder="Nhập tên thể loại" value="{{ old('tentheloai') }}" required>
                    @if ($errors->has('tentheloai'))
                        <div class="text-danger">{{ $errors->first('tentheloai') }}</div>
                    @endif

                    <label for="nhom">Nhóm (*)</label>
                    <select id="nhom" name="nhom" required>
                        <option value="">-- Chọn nhóm --</option>
                        <option value="Nhạc Rock" {{ old('nhom') == 'Nhạc Rock' ? 'selected' : '' }}>Nhạc Rock</option>
                        <option value="Nhạc Remix" {{ old('nhom') == 'Nhạc Remix' ? 'selected' : '' }}>Nhạc Remix</option>
                        <option value="Nhạc Nổi Bật" {{ old('nhom') == 'Nhạc Nổi Bật' ? 'selected' : '' }}>Nhạc Nổi Bật</option>
                        <option value="Nhạc Mới" {{ old('nhom') == 'Nhạc Mới' ? 'selected' : '' }}>Nhạc Mới</option>
                    </select>
                    @if ($errors->has('nhom'))
                        <div class="text-danger">{{ $errors->first('nhom') }}</div>
                    @endif

                    <label for="description">Mô tả thể loại</label>
                    <textarea id="description" name="description" rows="4" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <div class="text-danger">{{ $errors->first('description') }}</div>
                    @endif

                    <label for="status">Trạng thái hoạt động</label>
<select name="status" id="status" required>
    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Hoạt động</option>
    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Không hoạt động</option>
</select>
@if ($errors->has('status'))
    <div class="text-danger">{{ $errors->first('status') }}</div>
@endif


                    <label for="image">Ảnh đại diện</label>
                    <input type="file" name="image" id="image" accept="image/*">
                    @if ($errors->has('image'))
                        <div class="text-danger">{{ $errors->first('image') }}</div>
                    @endif

                    <button type="submit">Thêm</button>
                </form>
            </section>

        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
