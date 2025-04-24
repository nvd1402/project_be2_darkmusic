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
        @include('admin.users.search')

        <!--content-->
        <div>
            <h2 class="title">Sửa thông tin người dùng</h2>
            <p class="subtitle">Quản lý người dùng / Sửa thông tin người dùng</p>
        </div>
        <section class="add-user">
            <p class="notee">Lưu ý: Những trường hợp (*) là trường hợp bắt buộc.</p>
            <form action="{{ route('admin.users.update', $user->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Đảm bảo sử dụng phương thức PUT để cập nhật -->
                <div class="form-row">
                    <div class="form-group half">
                        <label for="username">Họ tên (*)</label>
                        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" placeholder="Hiển thị lại nội dung của người dùng" required>
                    </div>

                    <div class="form-group half">
                        <label for="password">Mật khẩu (*)</label>
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu mới (nếu có)">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email (*)</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Hiển thị lại nội dung của người dùng" required>
                    </div>

                    <div class="form-group half">
                        <label for="password_confirmation">Nhập lại mật khẩu (*)</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu mới">
                    </div>
                </div>
                <div class="form-row">
                <div class="form-group form-group-center">
                    <label for="status">Trạng thái tài khoản (*)</label>
                    <select id="status" name="status" required>
                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Vô hiệu hóa</option>
                    </select>
                </div>

                <div class="form-group form-group-center">
                    <label for="role">Quyền hạn (*)</label>
                    <select id="role" name="role" required>
                        <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option>
                        <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Vip" {{ $user->role == 'Vip' ? 'selected' : '' }}>VIP</option>
                    </select>
                </div>
                </div>
                <div class="form-groupp fullinput">
                    <label for="avatar">Tệp file ảnh đại diện</label>
                    <input style="width: 100%" type="file" id="avatar" name="avatar" accept="image/*">
                    <small>Chỉ chấp nhận ảnh định dạng jpg, png, tối đa 2MB.</small>
                    @if($user->avatar)
                        <div>
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" style="width: 150px; height: 150px;">
                        </div>
                    @endif
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn primary">Cập nhật tài khoản</button>
                    <button type="reset" class="btn">Hủy</button>
                </div>
            </form>
        </section>
    </main>
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
