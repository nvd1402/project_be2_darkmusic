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

                <!-- Hiển thị lỗi nếu có -->
                @if ($errors->any())
                    <div class="error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <p>Lưu ý những trường hợp có (*) là bắt buộc phải điền</p>
                    <br>
                    <!-- Tiêu đề -->
                    <label for="tieude">Tiêu đề(*)</label>
                    <input type="text" id="tieude" name="tieude" placeholder="Nhập tiêu đề tin tức" value="{{ old('tieude') }}" required>

                    <!-- Nội dung -->
                    <label for="noidung">Nội dung(*)</label>
                    <textarea id="noidung" name="noidung" placeholder="Nhập nội dung tin tức" required>{{ old('noidung') }}</textarea>

                    <!-- Đơn vị đăng -->
                    <label for="donvidang">Đơn vị đăng(*)</label>
                    <input type="text" id="donvidang" name="donvidang" placeholder="Nhập đơn vị đăng tin" value="{{ old('donvidang') }}" required>

                    <!-- Hình ảnh -->
                    <label for="hinhanh">Hình ảnh</label>
                    <input type="file" id="hinhanh" name="hinhanh">

                    <button type="submit">Thêm mới</button>
                </form>
            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
