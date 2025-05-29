<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.partials.head')
    <style>
        /* CSS nội tuyến tạm thời, bạn nên đưa vào file CSS riêng */
        body {
            font-family: sans-serif;
            background-color: #121212; /* Nền tối tổng thể */
            color: #E0E0E0; /* Màu chữ tổng thể */
            margin: 0;
            display: flex; /* Dùng flexbox cho layout chính */
        }

        .container {
            display: flex;
            width: 100%;
        }

        /* ----- Styles cho phần MAIN CONTENT (giữa) ----- */
        main {
            flex-grow: 1; /* Cho phép main chiếm hết không gian còn lại */
            background-color: #1C1C1C; /* Nền tối hơn cho main content */
            padding: 20px;
            overflow-y: auto; /* Cho phép cuộn nếu nội dung dài */
            height: 100vh; /* Chiều cao đầy đủ để cuộn */
            display: flex;
            flex-direction: column;
        }

        main header {
            display: flex;
            justify-content: space-between; /* Đẩy menu-btn sang trái, search sang phải */
            align-items: center;
            padding: 10px 0;
            margin-bottom: 20px;
        }

        main .search {
            background-color: #282828;
            border-radius: 20px;
            padding: 8px 15px;
            display: flex;
            align-items: center;
            width: 300px; /* Độ rộng của thanh tìm kiếm */
        }

        main .search i {
            color: #B3B3B3;
            margin-right: 10px;
        }

        main .search input {
            background: none;
            border: none;
            outline: none;
            color: #E0E0E0;
            width: 100%;
            font-size: 14px;
        }

        main .search input::placeholder {
            color: #808080;
        }

        /* Nút menu-btn (tùy chỉnh nếu dùng) */
        .menu-btn {
            background: none;
            border: none;
            color: #E0E0E0;
            font-size: 24px;
            cursor: pointer;
            display: none; /* Ẩn mặc định, có thể hiển thị trên mobile */
        }

        /* ----- Styles cho Danh sách nhạc yêu thích ----- */
        .favorite-songs-section {
            background-color: #282828; /* Nền của box danh sách nhạc */
            border-radius: 8px;
            padding: 20px;
            flex-grow: 1; /* Cho phép phần này giãn nở */
        }

        .favorite-songs-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .favorite-songs-header h2 {
            font-size: 24px;
            color: #E0E0E0;
            margin: 0;
        }

        .favorite-songs-header .play-all-btn {
            background-color: #1DB954; /* Màu xanh lá của Spotify */
            color: white;
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .song-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .song-item {
            display: flex;
            width: 700px;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #333;
        }

        .song-item:last-child {
            border-bottom: none;
        }

        .song-item-image {
            width: 50px;
            height: 50px;
            border-radius: 4px;
            object-fit: cover;
            margin-right: 15px;
        }

        .song-item-details {
            flex-grow: 1;
        }

        .song-item-details h4 {
            font-size: 16px;
            color: #E0E0E0;
            margin: 0 0 5px 0;
        }

        .song-item-details p {
            font-size: 14px;
            color: #B3B3B3;
            margin: 0;
        }

        .song-item-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .song-item-actions button {
            background: none;
            border: none;
            color: #B3B3B3;
            font-size: 20px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .song-item-actions button:hover {
            color: #E0E0E0;
        }

        /* --- Tạm thời cho Font Awesome icons nếu bạn dùng --- */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
        /* Bạn cũng cần thêm Boxicons nếu dùng class 'bx' */
        @import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');

        /* Responsive adjustments (tùy chỉnh thêm nếu cần) */
        @media (max-width: 768px) {
            main header {
                flex-direction: column;
                align-items: flex-start;
            }
            main .search {
                width: 100%;
                margin-top: 10px;
            }
            .menu-btn {
                display: block; /* Hiển thị nút menu trên màn hình nhỏ */
            }
        }

    </style>
</head>
<body>
<div class="container">
    @include('frontend.partials.sidebar')
    <main>
        <header>
            <div class="nav-links">
                <button class="menu-btn" id="menu-open">
                    <i class='bx bx-menu'></i>
                </button>
            </div>

            <div class="search">
                <i class='bx bx-search-alt-2'></i>
                <input type="text" placeholder="Tìm kiếm thông tin bài hát">
            </div>
        </header>

        <div class="favorite-songs-section">
            <div class="favorite-songs-header">
                <h2>Danh sách nhạc yêu thích</h2>
            </div>

            <ul class="song-list">
                @foreach($favorites as $favorite)
                    @if($favorite->song) {{-- Luôn kiểm tra để tránh lỗi nếu song bị null --}}
                    <li class="song-item">
                        @if($favorite->song->anh_daidien)
                            <img src="{{ asset('storage/' . $favorite->song->anh_daidien) }}" width="50" alt="Ảnh bìa" class="song-item-image">
                        @else
                            <img src="https://via.placeholder.com/50/FF6347/FFFFFF?text=NoImg" width="50" alt="Không có ảnh" class="song-item-image">
                        @endif
                        <div class="song-item-details">
                            <h4>{{ $favorite->song->tenbaihat }}</h4>
                            {{-- Lấy tên nghệ sĩ: Đảm bảo đã with('song.artist') trong Controller --}}
                            <p>{{ $favorite->song->artist->name_artist ?? 'N/A' }}</p>
                        </div>

                        <div class="song-item-actions">
                            <div class="song-audio">
                                {{-- Sửa: $song->file_amthanh thành $favorite->song->file_amthanh --}}
                                <audio id="audio-{{ $favorite->song->id }}" src="{{ asset('storage/'. $favorite->song->file_amthanh) }}"></audio>
                                <div class="audio-controls">
                                    {{-- Sửa: $song->id thành $favorite->song->id --}}
                                    <button class="play-pause-button" data-audio-id="audio-{{ $favorite->song->id }}">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    <span class="audio-duration">0:00 / 0:00</span>
                                </div>
                            </div>
                            <button style="margin-right: 10px;"><i class='bx bx-x-circle'></i></button>
                        </div>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </main>

    @include('frontend.partials.right_content')
</div>

<script src="https://kit.fontawesome.com/your-font-awesome-kit-id.js" crossorigin="anonymous"></script>
<script type='text/javascript' src="{{ asset('assets/frontend/js/script.js') }}"></script>
<script type='text/javascript' src="{{ asset('assets/frontend/js/audio-controls.js') }}"></script>
<script type='text/javascript' src="{{ asset('assets/frontend/js/songs.js') }}"></script>
<script src="{{ asset('assets/frontend/js/handle-ad.js') }}"></script>

</body>
</html>
