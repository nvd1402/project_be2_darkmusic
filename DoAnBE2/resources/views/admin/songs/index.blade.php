<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
    <style>
        main {
            overflow-y: auto;
            /* Cho phép cuộn nếu nội dung dài */
            height: 100vh;
            /* Chiều cao đầy đủ để cuộn */
        }
        /* Style cơ bản cho thông báo */
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
    </style>
    @livewireStyles {{-- Đảm bảo có dòng này nếu bạn dùng Livewire --}}
</head>

<body>

<div class="container">
    @include('admin.partials.sidebar')

    <main>
        @include('admin.partials.header')

        <div>
            <h2 class="newTitle">Quản lý bài hát</h2>
        </div>

        {{-- ĐẶT PHẦN HIỂN THỊ THÔNG BÁO Ở ĐÂY --}}
        @if (session()->has('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('info'))
            <div class="alert-info">
                {{ session('info') }}
            </div>
        @endif

        <section class="song-list">
            <h2 class="newTitle" style="margin-top: -100px">Danh sách bài hát</h2>
            <div class="add-btn">
                <a href="{{ route('admin.songs.create') }}">Thêm mới</a>
            </div>

            @livewire('search-songs') {{-- Livewire component của bạn --}}
        </section>
    </main>
</div>

@livewireScripts {{-- Đảm bảo có dòng này nếu bạn dùng Livewire --}}
<script type='text/javascript' src="{{ asset('assets/frontend/js/adminSong.js') }}"></script>
</body>

</html>
