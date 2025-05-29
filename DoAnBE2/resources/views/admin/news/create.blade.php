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
                <h2 class="title">Thêm tin tức mới</h2>
            </div>

            <section class="news-form">
                <h3>Thêm tin tức</h3>

                

                <!-- resources/views/admin/news/create.blade.php -->
<form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <label for="tieude">Tiêu đề(*)</label>
    <input type="text" id="tieude" name="tieude" placeholder="Nhập tiêu đề tin tức" value="{{ old('tieude') }}" required>
    @if ($errors->has('tieude'))
        <div class="text-danger">{{ $errors->first('tieude') }}</div>
    @endif

    <label for="noidung">Nội dung(*)</label>
    <textarea id="noidung" name="noidung" placeholder="Nhập nội dung tin tức" required>{{ old('noidung') }}</textarea>
    @if ($errors->has('noidung'))
        <div class="text-danger">{{ $errors->first('noidung') }}</div>
    @endif

    <label for="donvidang">Đơn vị đăng(*)</label>
    <input type="text" id="donvidang" name="donvidang" placeholder="Nhập đơn vị đăng tin" value="{{ old('donvidang') }}" required>
    @if ($errors->has('donvidang'))
        <div class="text-danger">{{ $errors->first('donvidang') }}</div>
    @endif

    <label for="hinhanh">Hình ảnh</label>
    <input type="file" id="hinhanh" name="hinhanh">
    @if ($errors->has('hinhanh'))
        <div class="text-danger">{{ $errors->first('hinhanh') }}</div>
    @endif

    <button type="submit">Thêm mới</button>
</form>

            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
