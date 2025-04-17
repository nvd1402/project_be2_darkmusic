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
            <h2 class="title">Sửa thông tin người dùng</h2>
            <p class="subtitle">Quản lý người dùng / Sửa thông tin người dùng</p>
        </div>
        <section class="add-song">
            <p class="note">Lưu ý: Những trường hợp (*) là trường hợp bắt buộc.</p>
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group half">
                        <label for="tenuser">Họ tên (*)</label>
                        <input type="text" id="tennguoidung" name="tennguoidung" placeholder="Hiển thị lại nội dung của người dùng" required>
                    </div>

                    <div class="form-group half">
                        <label for="matkhauueser">Mật khẩu (*)</label>
                        <input type="text" id="matkhauuser" name="matkhau" placeholder="Hiển thị lại nội dung của người dùng" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="emailuser">Email (*)</label>
                        <input type="text" id="emailuser" name="email" placeholder="Hiển thị lại nội dung của người dùng" required>
                    </div>

                    <div class="form-group half">
                        <label for="nhaplaimatkhau">Nhập lại mật khẩu (*)</label>
                        <input type="text" id="nhaplaimatkhau" name="nhaplaimatkhau" placeholder="Hiển thị lại nội dung của người dùng" required>
                    </div>
                </div>

                <div class="form-group" style="margin-left: 410px;">
                    <label for="trangthaitaikhoan">Trạng thái tài khoản (*)</label>
                    <select id="trangthai" name="Trạng thái" required>
                        <option value="">-- Chọn trạng thái --</option>
                        <option value="nhactre">VIP</option>
                        <option value="kpop">User</option>
                        <option value="rap">Admin</option>
                    </select>
                </div>


                <div class="form-group fullinput">
                    <label for="anhdaidien">Tệp file ảnh đại diện</label>
                    <input  style="width: 810px"  type="file" id="anhdaidien" name="anhdaidien" accept="image/*">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn primary">Cập nhật tài khoản</button>
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
