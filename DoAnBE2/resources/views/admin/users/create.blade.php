<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.partials.head')
</head>
<body>

<div class="container">
    @include('admin.partials.sidebar')

    <main>
        <!-- Include file header -->
        @include('admin.partials.header')
        @include('admin.users.search')

        <!-- Content -->
        <div>
            <h2 class="title">Thêm người dùng</h2>
            <p class="subtitle">Quản lý người dùng / Thêm người dùng</p>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif
        <section class="add-user">
            <p class="notee">Lưu ý: Những trường hợp (*) là trường hợp bắt buộc.</p>

            <!-- Hiển thị thông báo thành công nếu có -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group half">
                        <label for="username">Họ tên (*)</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Nhập tên họ và tên" required class="{{ $errors->has('username') ? 'is-invalid' : '' }}">
                        @if ($errors->has('username'))
                            <div class="text-danger">{{ $errors->first('username') }}</div>
                        @endif
                    </div>

                    <div class="form-group half">
                        <label for="password">Mật khẩu (*)</label>
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                        @if ($errors->has('password'))
                            <div class="text-danger">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email (*)</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="vd: nvd@gmail.com" required class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @if ($errors->has('email'))
                            <div class="text-danger">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="form-group half">
                        <label for="password_confirmation">Nhập lại mật khẩu (*)</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" required class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}">
                        @if ($errors->has('password_confirmation'))
                            <div class="text-danger">{{ $errors->first('password_confirmation') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-row">
                <div class="form-group" >
                    <label for="status">Trạng thái tài khoản (*)</label>
                    <select id="status" name="status" required class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <option value="">-- Chọn trạng thái --</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Vô hiệu hóa</option>
                    </select>
                    @if ($errors->has('status'))
                        <div class="text-danger">{{ $errors->first('status') }}</div>
                    @endif
                </div>

                <div class="form-group half">
                    <label for="role">Quyền hạn (*)</label>
                    <select id="role" name="role" required class="{{ $errors->has('role') ? 'is-invalid' : '' }}">
                        <option value="">-- Chọn quyền hạn --</option>
                        <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Vip" {{ old('role') == 'Vip' ? 'selected' : '' }}>VIP</option>
                    </select>
                    @if ($errors->has('role'))
                        <div class="text-danger">{{ $errors->first('role') }}</div>
                    @endif
                </div>
                </div>
                <div class="form-groupp fullinput">
                    <label for="avatar">Tệp file ảnh đại diện</label>
                    <input style="width: 100%" type="file" id="avatar" name="avatar" accept="image/*" class="{{ $errors->has('avatar') ? 'is-invalid' : '' }}">
                    <small>Chỉ chấp nhận ảnh định dạng jpg, png, tối đa 2MB.</small>
                    @if ($errors->has('avatar'))
                        <div class="text-danger">{{ $errors->first('avatar') }}</div>
                    @endif
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn primary">Thêm tài khoản mới</button>
                    <button type="reset" class="btn">Hủy</button>
                </div>
            </form>
        </section>
    </main>
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
