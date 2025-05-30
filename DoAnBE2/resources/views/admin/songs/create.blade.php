<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.partials.head')
    <style>
        /* Styles cho các thông báo tổng hợp */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        /* Style cho lỗi validation dưới từng trường */
        .text-danger {
            color: #e3342f;
            font-size: 0.875em;
            margin-top: 5px;
            display: block;
        }

    </style>
</head>
<body>
<div class="container">
    @include('admin.partials.sidebar')
    <main>
        @include('admin.partials.header')

        <div>
            <h2 class="title">Thêm bài hát</h2>
            <p class="subtitle">Quản lý bài hát / Thêm bài hát</p>
        </div>

        {{-- HIỂN THỊ CÁC THÔNG BÁO FLASH MESSAGE (success, error, info) --}}
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif
        @if (session('info'))
            <div class="alert-info">
                {{ session('info') }}
            </div>
        @endif

        {{-- HIỂN THỊ TẤT CẢ LỖI VALIDATION TỔNG HỢP --}}
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="add-song">
            <p class="note">Lưu ý: Những trường hợp (*) là trường hợp bắt buộc.</p>
            <form action="{{ route('admin.songs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group half">
                        <label for="tenbaihat">Tên bài hát (*)</label>
                        <input type="text" id="tenbaihat" name="tenbaihat" placeholder="Nhập tên bài hát" value="{{ old('tenbaihat') }}" required>
                        @error('tenbaihat')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="nghesi">Nghệ sĩ (*)</label>
                        <select id="nghesi" name="nghesi" required>
                            <option value="">-- Chọn nghệ sĩ --</option>
                            @foreach ($artists as $artist)
                                <option value="{{ $artist->id }}" {{ old('nghesi') == $artist->id ? 'selected' : '' }}>{{ $artist->name_artist }}</option>
                            @endforeach
                        </select>
                        @error('nghesi')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="theloai">Thể loại (*)</label>
                    <select id="theloai" name="theloai" required>
                        <option value="">-- Chọn thể loại --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('theloai') == $category->id ? 'selected' : '' }}>{{ $category->tentheloai }}</option>
                        @endforeach
                    </select>
                    @error('theloai')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group full">
                    <label for="file_amthanh">Tệp file âm thanh (*)</label>
                    <input style="width: 100%" type="file" id="file_amthanh" name="file_amthanh" accept="audio/*" required>
                    <small>Chỉ chấp nhận file mp3, wav, ogg.</small>
                    @error('file_amthanh')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group fullinput">
                    <label for="anh_daidien">Tệp file ảnh đại diện</label>
                    <input style="width: 100%" type="file" id="anh_daidien" name="anh_daidien" accept="image/*">
                    <small>Chỉ chấp nhận ảnh định dạng jpg, png, tối đa 2MB.</small>
                    @error('anh_daidien')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn primary">Thêm bài hát mới</button>
                    <button type="reset" class="btn primary"><a href="{{ route('admin.songs.index') }}">Hủy</a></button>
                </div>
            </form>

        </section>
    </main>
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
