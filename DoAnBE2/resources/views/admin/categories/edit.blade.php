<!-- resources/views/admin/categories/edit.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
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

                    <label for="category-name">Tên thể loại</label>
                    <input type="text" name="tentheloai" value="{{ old('tentheloai', $category->tentheloai ?? '') }}" placeholder="Nhập tên thể loại" required>
                    @if ($errors->has('tentheloai'))
                        <div class="text-danger">{{ $errors->first('tentheloai') }}</div>
                    @endif

                    <label for="nhom">Nhóm</label>
                    <select name="nhom" id="nhom" required>
                        <option value="">-- Chọn nhóm --</option>
                        <option value="Nhạc Rock" {{ old('nhom', $category->nhom ?? '') == 'Nhạc Rock' ? 'selected' : '' }}>Nhạc Rock</option>
                        <option value="Nhạc Remix" {{ old('nhom', $category->nhom ?? '') == 'Nhạc Remix' ? 'selected' : '' }}>Nhạc Remix</option>
                        <option value="Nhạc Nổi Bật" {{ old('nhom', $category->nhom ?? '') == 'Nhạc Nổi Bật' ? 'selected' : '' }}>Nhạc Nổi Bật</option>
                        <option value="Nhạc Mới" {{ old('nhom', $category->nhom ?? '') == 'Nhạc Mới' ? 'selected' : '' }}>Nhạc Mới</option>
                    </select>
                    @if ($errors->has('nhom'))
                        <div class="text-danger">{{ $errors->first('nhom') }}</div>
                    @endif

                    <label for="image">Ảnh đại diện (nếu muốn thay đổi)</label><br>
                    @if($category->image)
                        <img src="{{ asset('uploads/categories/' . $category->image) }}" alt="Ảnh thể loại" style="width: 100px; height: auto; margin-bottom: 10px; border-radius: 5px;">
                    @endif
                    <input type="file" name="image" id="image" accept="image/*">
                    @if ($errors->has('image'))
                        <div class="text-danger">{{ $errors->first('image') }}</div>
                    @endif

                    <br><br>
                    <button type="submit">Cập nhật</button>
                </form>
            </section>

        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
