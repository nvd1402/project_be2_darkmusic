



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
            <!-- include file header -->
            @include('admin.partials.header')

            <!-- Content -->
            <div>
                <h2 class="title">Chỉnh sửa album</h2>
            </div>
<section class="category-form">
    <h3>Chỉnh sửa album</h3>

   <!-- Hiển thị lỗi -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.album.update', $album->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Dùng POST nếu bạn đang xử lý bằng route post -->

                    <!-- Tên Album -->
                    <div class="mb-3">
                        <label for="ten_album" class="form-label">Tên Album <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten_album') is-invalid @enderror"
                               id="ten_album" name="ten_album" value="{{ old('ten_album', $album->ten_album) }}" required>
                        @error('ten_album')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Chọn Nghệ sĩ -->
                    <div class="mb-3">
                        <label for="nghe_si" class="form-label">Chọn Nghệ sĩ <span class="text-danger">*</span></label>
                        <select class="form-select @error('nghe_si') is-invalid @enderror" id="nghe_si" name="nghe_si" required>
                            <option value="">-- Chọn nghệ sĩ --</option>
                            @foreach($artists as $artist)
                                <option value="{{ $artist->name_artist }}"
                                    {{ old('nghe_si', $album->nghe_si) == $artist->name_artist ? 'selected' : '' }}>
                                    {{ $artist->name_artist }}
                                </option>
                            @endforeach
                        </select>
                        @error('nghe_si')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ảnh bìa -->
                    <div class="mb-4">
                        <label for="anh_bia" class="form-label">Ảnh bìa Album</label>
                        <input class="form-control @error('anh_bia') is-invalid @enderror" type="file" id="anh_bia" name="anh_bia">
                        @error('anh_bia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($album->anh_bia)
                            <div class="mt-3">
                                <p>Ảnh hiện tại:</p>
                                <img src="{{ asset('storage/' . $album->anh_bia) }}" alt="Ảnh bìa album" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-success">Cập nhật Album</button>
                </form>
            </section>
        </main>
    </div>


    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
