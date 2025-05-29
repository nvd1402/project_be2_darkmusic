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
                <h2 class="title">Chỉnh sửa tin tức</h2>
            </div>

            <section class="news-form">
                <h3>Chỉnh sửa tin tức</h3>

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
                    {{-- Trường ẩn để kiểm tra updated_at, quan trọng cho việc xử lý xung đột --}}
                    <input type="hidden" name="updated_at" value="{{ $news->updated_at }}">

                    <label for="tieude">Tiêu đề</label>
                    <input type="text" id="tieude" name="tieude" value="{{ old('tieude', $news->tieude) }}" required>
                    @if ($errors->has('tieude'))
                        <div class="text-danger">{{ $errors->first('tieude') }}</div>
                    @endif

                    <label for="noidung">Nội dung</label>
                    <textarea id="noidung" name="noidung" required>{{ old('noidung', $news->noidung) }}</textarea>
                    @if ($errors->has('noidung'))
                        <div class="text-danger">{{ $errors->first('noidung') }}</div>
                    @endif

                    <label for="donvidang">Đơn vị đăng</label>
                    <input type="text" id="donvidang" name="donvidang" value="{{ old('donvidang', $news->donvidang) }}" required>
                    @if ($errors->has('donvidang'))
                        <div class="text-danger">{{ $errors->first('donvidang') }}</div>
                    @endif

                    <div class="form-group">
                        <label>Hình ảnh hiện tại</label>
                        <div>
                            @if ($news->hinhanh)
                                {{-- Hiển thị ảnh hiện tại --}}
                                <img src="{{ asset('storage/' . $news->hinhanh) }}" alt="Ảnh tin tức hiện tại" class="news-image-preview" style="max-width: 200px; height: auto; margin-bottom: 10px;">
                                
                            @else
                                <p>Chưa có ảnh nào được tải lên cho tin tức này.</p>
                            @endif
                        </div>

                        <label for="hinhanh">Cập nhật hình ảnh (tùy chọn)</label>
                        <input type="file" id="hinhanh" name="hinhanh" class="form-control-file">
                        @if ($errors->has('hinhanh'))
                            <div class="text-danger mt-1">{{ $errors->first('hinhanh') }}</div>
                        @endif
                    </div>
                    
                    <button type="submit">Cập nhật</button>
                </form>
            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>