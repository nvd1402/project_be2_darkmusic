<!-- resources/views/admin/categories/create.blade.php -->
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
                <h2 class="title">Thêm thể loại mới</h2>
            </div>

           <section class="category-form">
    <h3>Thêm thể loại</h3>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <p>Lưu ý những trường hợp có (*) là bắt buộc phải điền</p>
        <br>
        <label for="category-name">Tên thể loại(*)</label>
        <input type="text" id="category-name" name="tentheloai" placeholder="Nhập tên thể loại" value="{{ old('tentheloai') }}" required>
        @if ($errors->has('tentheloai'))
            <div class="text-danger">{{ $errors->first('tentheloai') }}</div>
        @endif

        <label for="category-group">Nhóm(*)</label>
        <select id="category-group" name="nhom" required>
            <option value="">-- Chọn nhóm --</option>
            <option value="Nhạc Rock" {{ old('nhom') == 'Nhạc Rock' ? 'selected' : '' }}>Nhạc Rock</option>
            <option value="Nhạc Remix" {{ old('nhom') == 'Nhạc Remix' ? 'selected' : '' }}>Nhạc Remix</option>
            <option value="Nhạc Nổi Bật" {{ old('nhom') == 'Nhạc Nổi Bật' ? 'selected' : '' }}>Nhạc Nổi Bật</option>
            <option value="Nhạc Mới" {{ old('nhom') == 'Nhạc Mới' ? 'selected' : '' }}>Nhạc Mới</option>
        </select>
        @if ($errors->has('nhom'))
            <div class="text-danger">{{ $errors->first('nhom') }}</div>
        @endif

        <button type="submit">Thêm</button>
    </form>
</section>

        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
