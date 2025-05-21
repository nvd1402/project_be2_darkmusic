<!DOCTYPE html>
<html lang="en">
<head>@include('frontend.partials.head')
    <style>
        .main-content {
            color: #fff;
        }
        /* nếu có các thành phần cụ thể cần override */
        .main-content h2,
        .main-content .row > div {
            color: #fff;
        }
        .main-content {
            color: #fff;
            background-color: #222; /* nền tối cho vùng chính */
            padding: 20px;
            border-radius: 8px;
        }

        /* Các ô label */
        .main-content .row > div.col-sm-4 {
            background-color: #444; /* nền đậm hơn một chút */
            padding: 10px;
            border-radius: 4px 0 0 4px;
            font-weight: 600;
        }

        /* Các ô dữ liệu */
        .main-content .row > div.col-sm-8 {
            background-color: #333; /* nền vừa phải */
            padding: 10px;
            border-radius: 0 4px 4px 0;
        }

        /* Khoảng cách giữa các dòng */
        .main-content .row.mb-3 {
            margin-bottom: 15px;
        }

        /* Badge trạng thái */
        .badge.bg-success {
            background-color: #28a745 !important;
        }
        .badge.bg-secondary {
            background-color: #6c757d !important;
        }

    </style>

</head>
<body class="text-light">>
<div class="container">
    <!-- Sidebar -->
    @include('frontend.partials.sidebar')
    <main class="main-content">
        {{-- Tiêu đề --}}
        <h2 class="mb-4">Thông tin tài khoản</h2>

        {{-- Thông tin user --}}
        <div class="row mb-3">
            <div class="col-sm-4"><strong>Username:</strong></div>
            <div class="col-sm-8">{{ Auth::user()->username }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-4"><strong>Email:</strong></div>
            <div class="col-sm-8">{{ Auth::user()->email }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-4"><strong>Vai trò:</strong></div>
            <div class="col-sm-8">{{ Auth::user()->role }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-4"><strong>Trạng thái:</strong></div>
            <div class="col-sm-8">
                @if(Auth::user()->status === 'active')
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-secondary">Inactive</span>
                @endif
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-4"><strong>Ngày tạo tài khoản:</strong></div>
            <div class="col-sm-8">{{ Auth::user()->created_at->format('d/m/Y H:i') }}</div>
        </div>
        {{-- Nút đăng xuất --}}
        <form action="{{ route('logout') }}" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="btn btn-danger">Đăng xuất</button>
        </form>

    </main>



</div>
</div>

<script type='text/javascript' src="script.js"></script>
</body>
</html>
