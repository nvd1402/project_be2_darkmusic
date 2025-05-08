<!DOCTYPE html>
<html lang="en">
<head>@include('admin.partials.head')</head>
<body>
<div class="container">
    <!-- Include Sidebar -->
    @include('admin.partials.sidebar')
    <!-- Main Content -->
    <main>
        <!-- Include Header -->
        @include('admin.partials.header')

        <!-- Content -->
        <div>
            <h2 class="title">Sửa thông tin bài hát</h2>
            <p class="subtitle">Quản lý bài hát / Sửa thông tin bài hát</p>
        </div>

        <section class="add-song">
            <p class="note">Lưu ý: Những trường hợp (*) là trường hợp bắt buộc.</p>

            <form action="{{ route('admin.songs.update', $song->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group half">
                        <label for="tenbaihat">Tên bài hát (*)</label>
                        <input type="text" id="tenbaihat" name="tenbaihat" value="{{ old('tenbaihat', $song->tenbaihat) }}" required>
                    </div>

                    <div class="form-group half">
                        <label for="nghesi">Nghệ sĩ (*)</label>
                        <select id="nghesi" name="nghesi" required>
                            <option value="">-- Chọn nghệ sĩ --</option>
                            @foreach ($artists as $artist)
                                <option value="{{ $artist->id }}" {{ $song->nghesi == $artist->id ? 'selected' : '' }}>
                                    {{ $artist->name_artist }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="theloai">Thể loại (*)</label>
                    <select id="theloai" name="theloai" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->tentheloai }}" {{ $song->theloai == $category->tentheloai ? 'selected' : '' }}>
                                {{ $category->tentheloai }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group full">
                    <label for="file_amthanh">Tệp file âm thanh (*)</label>
                    <input style="width: 810px" type="file" id="file_amthanh" name="file_amthanh" accept="audio/*">
                    <small>Chỉ chấp nhận file mp3, wav, ogg.</small>
                    @if($song->file_amthanh)
                        <div style="margin-top: 10px;">
                            <p>File âm thanh hiện tại:</p>
                            <audio controls>
                                <source src="{{ asset('storage/' . $song->file_amthanh) }}" type="audio/mpeg">
                                Trình duyệt của bạn không hỗ trợ phát âm thanh.
                            </audio>
                        </div>
                    @endif
                </div>

                <div class="form-group fullinput">
                    <label for="anh_daidien">Tệp file ảnh đại diện</label>
                    <input style="width: 810px" type="file" id="anh_daidien" name="anh_daidien" accept="images/*">
                    <small>Chỉ chấp nhận ảnh định dạng jpg, png, tối đa 2MB.</small>
                    @if($song->anh_daidien)
                        <div>
                            <p>Ảnh đại diện hiện tại:</p>
                            <img src="{{ asset('storage/' . $song->anh_daidien) }}" alt="anh_daidien" width="100px">
                        </div>
                    @endif
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn primary">Chỉnh sửa</button>
                    <button type="reset" class="btn">Hủy</button>
                </div>
            </form>
        </section>
    </main>
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
