

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
     <form action="{{ route('admin.album.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <p>Lưu ý những trường hợp có (*) là bắt buộc phải điền</p>
                    <br>

                    <!-- Tên Album -->
                    <label for="ten_album">Tên Album(*)</label>
                    <input type="text" id="ten_album" name="ten_album" placeholder="Nhập tên album" value="{{ old('ten_album') }}" required>
                    @if ($errors->has('ten_album'))
                        <div class="text-danger">{{ $errors->first('ten_album') }}</div>
                    @endif

                    <!-- Nghệ sĩ -->
                    <label for="nghe_si">Chọn Nghệ sĩ(*)</label>
                    <select id="nghe_si" name="nghe_si" required>
                        <option value="">-- Chọn nghệ sĩ --</option>
                        @foreach($artists as $artist)
                            <option value="{{ $artist->name_artist }}" {{ old('nghe_si') == $artist->name_artist ? 'selected' : '' }}>
                                {{ $artist->name_artist }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('nghe_si'))
                        <div class="text-danger">{{ $errors->first('nghe_si') }}</div>
                    @endif

                    <!-- Ảnh bìa -->
                    <label for="anh_bia">Ảnh bìa Album</label>
                    <input type="file" id="anh_bia" name="anh_bia">
                    @if ($errors->has('anh_bia'))
                        <div class="text-danger">{{ $errors->first('anh_bia') }}</div>
                    @endif

                    <!-- Nút gửi -->
                    <button type="submit">Thêm mới</button>
                </form>
            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
