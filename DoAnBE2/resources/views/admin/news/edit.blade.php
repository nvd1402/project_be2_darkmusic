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

                <!-- Hiển thị lỗi nếu có -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
<input type="hidden" name="updated_at" value="{{ $news->updated_at }}">
                    <!-- Tiêu đề -->
                    <label for="tieude">Tiêu đề</label>
                    <input type="text" id="tieude" name="tieude" value="{{ old('tieude', $news->tieude) }}" required>
                    @if ($errors->has('tieude'))
                        <div class="text-danger">{{ $errors->first('tieude') }}</div>
                    @endif

                    <!-- Nội dung -->
                    <label for="noidung">Nội dung</label>
                    <textarea id="noidung" name="noidung" required>{{ old('noidung', $news->noidung) }}</textarea>
                    @if ($errors->has('noidung'))
                        <div class="text-danger">{{ $errors->first('noidung') }}</div>
                    @endif

                    <!-- Đơn vị đăng -->
                    <label for="donvidang">Đơn vị đăng</label>
                    <input type="text" id="donvidang" name="donvidang" value="{{ old('donvidang', $news->donvidang) }}" required>
                    @if ($errors->has('donvidang'))
                        <div class="text-danger">{{ $errors->first('donvidang') }}</div>
                    @endif

                    <!-- Hình ảnh -->
                    <label for="hinhanh">Hình ảnh</label>
                    <input type="file" id="hinhanh" name="hinhanh">
                    @if ($errors->has('hinhanh'))
                        <div class="text-danger">{{ $errors->first('hinhanh') }}</div>
                    @endif

                    <button type="submit">Cập nhật</button>
                </form>
            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
