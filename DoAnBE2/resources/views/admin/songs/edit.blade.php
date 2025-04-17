<!DOCTYPE html>
<html lang="en">
<head>@include('admin.partials.head')</head>
<body>
<div class="container">
    <!--include file sidebar-->
    @include('admin.partials.sidebar')
    <!-- phân chính -->
    <main>
        <!--include file header-->
        @include('admin.partials.header')

        <!--content-->
        <div>
            <h2 class="title">Sửa thông tin bài hát</h2>
            <p class="subtitle">Quản lý bài hát / Sửa thông tin bài hát</p>
        </div>
        <section class="add-song">
            <p class="note">Lưu ý: Những trường hợp (*) là trường hợp bắt buộc.</p>
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group half">
                        <label for="tenbaihat">Tên bài hát (*)</label>
                        <input type="text" id="tenbaihat" name="tenbaihat" placeholder="Hiện thị lại thông tin bài hát" required>
                    </div>

                    <div class="form-group half">
                        <label for="nghesi">Nghệ sĩ (*)</label>
                        <select id="nghesi" name="nghesi" required>
                            <option value="">-- Chọn nghệ sĩ --</option>
                            <option value="1">Jack 97</option>
                            <option value="2">Jisoo</option>
                            <option value="3">Sơn Tùng MTP</option>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label for="theloai">Thể loại (*)</label>
                    <select id="theloai" name="theloai" required>
                        <option value="">-- Chọn thể loại --</option>
                        <option value="nhactre">Nhạc trẻ</option>
                        <option value="kpop">Kpop</option>
                        <option value="rap">Rap Việt</option>
                    </select>
                </div>

                <div class="form-group full">
                    <label for="file_amthanh">Tệp file âm thanh (*)</label>
                    <input style="width: 810px" type="file" id="file_amthanh" name="file_amthanh" accept="audio/*" required>
                </div>

                <div class="form-group fullinput">
                    <label for="anhdaidien">Tệp file ảnh đại diện</label>
                    <input  style="width: 810px"  type="file" id="anhdaidien" name="anhdaidien" accept="image/*">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn primary">Thêm bài hát mới</button>
                    <button type="reset" class="btn">Hủy</button>
                </div>
            </form>
        </section>
    </main>
</div>

</div>



<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
