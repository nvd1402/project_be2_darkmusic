<!-- resources/views/admin/news/edit.blade.php -->
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
                <h2 class="title">Chỉnh sửa tin tức</h2>
            </div>

            <section class="news-form">
                <h3>Chỉnh sửa tin tức</h3>
                <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label for="tieude">Tiêu đề</label>
                    <input type="text" id="tieude" name="tieude" value="{{ $news->tieude }}" required>

                    <label for="noidung">Nội dung</label>
                    <textarea id="noidung" name="noidung" required>{{ $news->noidung }}</textarea>

                    <label for="donvidang">Đơn vị đăng</label>
                    <input type="text" id="donvidang" name="donvidang" value="{{ $news->donvidang }}" required>

                    <label for="hinhanh">Hình ảnh</label>
                    <input type="file" id="hinhanh" name="hinhanh">

                    <button type="submit">Cập nhật</button>
                </form>
            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
