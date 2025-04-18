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
                            <option value="Jack97" {{ $song->nghesi == 'Jack97' ? 'selected' : '' }}>Jack97</option>
                            <option value="Jisoo" {{ $song->nghesi == 'Jisoo' ? 'selected' : '' }}>Jisoo</option>
                            <option value="Sơn Tùng MTP" {{ $song->nghesi == 'Sơn Tùng MTP' ? 'selected' : '' }}>Sơn Tùng MTP</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="theloai">Thể loại (*)</label>
                    <select id="theloai" name="theloai" required>
                        <option value="Nhạc trẻ" {{ $song->theloai == 'Nhạc trẻ' ? 'selected' : '' }}>Nhạc trẻ</option>
                        <option value="Kpop" {{ $song->theloai == 'Kpop' ? 'selected' : '' }}>Kpop</option>
                        <option value="Rap Việt" {{ $song->theloai == 'Rap Việt' ? 'selected' : '' }}>Rap Việt</option>
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
                    <label for="anhdaidien">Tệp file ảnh đại diện</label>
                    <input style="width: 810px" type="file" id="anhdaidien" name="anhdaidien" accept="image/*">
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
