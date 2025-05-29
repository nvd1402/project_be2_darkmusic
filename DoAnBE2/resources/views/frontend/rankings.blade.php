<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.partials.head')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* CSS tùy chỉnh cho trang bảng xếp hạng */
        .song-info .views-count {
            font-size: 0.75em;
            color: #888; /* Màu xám nhạt */
            margin-top: 3px;
        }
        .song-item {
            position: relative;
            /* Đảm bảo khoảng cách giữa các phần tử trong song-item */
            display: flex;
            align-items: center;
            gap: 15px; /* Khoảng cách giữa các cột */
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .song-item:last-child {
            border-bottom: none;
        }
        .song-item .rank {
            font-size: 1.2em;
            font-weight: bold;
            color: #fff;
            min-width: 30px; /* Đảm bảo đủ chỗ cho số hạng */
            text-align: center;
        }
        .song-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .song-item .song-info {
            flex-grow: 1; /* Cho phép phần thông tin bài hát chiếm không gian còn lại */
        }
        .song-item .song-info h3 {
            margin: 0;
            font-size: 1em;
            color: #fff;
        }
        .song-item .song-info p {
            margin: 0;
            font-size: 0.8em;
            color: #bbb;
        }
        .song-item .duration {
            font-size: 0.8em;
            color: #bbb;
            min-width: 60px; /* Đảm bảo đủ chỗ cho thời lượng */
            text-align: right;
        }
        .song-item .play-btn {
            background: none;
            border: none;
            color: #1DB954; /* Màu xanh lá cây của Spotify */
            font-size: 2em;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        .song-item .play-btn:hover {
            color: #1ed760;
        }
        .song-columns {
            display: flex;
            gap: 30px; /* Khoảng cách giữa 2 cột bài hát */
        }
        .song-list {
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1; /* Chia đều không gian cho 2 cột */
        }
        /* Thêm style cho nút like (nếu bạn có) */
        .btn-like {
            background: transparent;
            border: none;
            font-size: 24px;
            color: white;
            cursor: pointer;
            margin-left: 10px; /* Khoảng cách với nút play */
        }
        .heart-float {
            position: absolute;
            animation: floatUp 1s ease-out;
            font-size: 18px;
            color: red;
            pointer-events: none;
        }
        @keyframes floatUp {
            0% { opacity: 1; transform: translateY(0) scale(1); }
            100% { opacity: 0; transform: translateY(-40px) scale(1.5); }
        }
    </style>
</head>
<body class="text-light">
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
                <input type="text" placeholder="type here to search">
            </div>
        </header>

        <section class="bxh-nhac-moi">
            <h2 class="title">BXH Top Thịnh Hành<i class='bx bx-play-circle'></i></h2>
            <div class="song-columns">
                <ul class="song-list">
                    @forelse($rankedSongs->take(5) as $index => $song)
                        <li class="song-item {{ $index < 3 ? 'active' : '' }}">
                            <span class="rank">{{ $index + 1 }}</span>
                            <img src="{{ asset('storage/' . $song->anh_daidien) }}" alt="{{ $song->tenbaihat }}">
                            <div class="song-info">
                                <h3>{{ $song->tenbaihat }}</h3>
                                <p>{{ $song->artist->name_artist ?? 'Nghệ sĩ không rõ' }}</p>
                                {{-- HIỂN THỊ LƯỢT XEM --}}
                                <span class="views-count" data-song-id="{{ $song->id }}">Lượt xem: {{ number_format($song->luot_xem ?? 0) }}</span>
                            </div>
                            <span class="audio-duration">0:00 / 0:00</span> {{-- Hiển thị thời lượng và thời gian hiện tại --}}
                            <audio id="audio-{{ $song->id }}" src="{{ asset('storage/'. $song->file_amthanh) }}"></audio>

                            <button class="play-pause-button" data-song-id="{{ $song->id }}" data-audio-id="audio-{{ $song->id }}">
                                <i class='bx bx-play-circle'></i>
                            </button>
                            @php
                                // Giả sử $userLikedSongIds được truyền từ controller hoặc lấy từ Auth::user()
                                $userLikedSongIds = auth()->check() ? auth()->user()->likedSongs->pluck('id')->toArray() : [];
                            @endphp
                            <button class="btn-like" data-song-id="{{ $song->id }}" style="background: transparent; border: none; font-size: 24px; color: white; cursor: pointer;">
                                {{ in_array($song->id, $userLikedSongIds) ? '♥' : '♡' }}
                            </button>
                        </li>
                    @empty
                        <li class="song-item">
                            <p>Không có bài hát nào trong bảng xếp hạng.</p>
                        </li>
                    @endforelse
                </ul>
                <ul class="song-list">
                    @forelse($rankedSongs->skip(5)->take(5) as $index => $song)
                        <li class="song-item">
                            <span class="rank">{{ $index + 6 }}</span>
                            <img src="{{ asset('storage/' . $song->anh_daidien) }}" alt="{{ $song->tenbaihat }}">
                            <div class="song-info">
                                <h3>{{ $song->tenbaihat }}</h3>
                                <p>{{ $song->artist->name_artist ?? 'Nghệ sĩ không rõ' }}</p>
                                {{-- HIỂN THỊ LƯỢT XEM --}}
                                <span class="views-count" data-song-id="{{ $song->id }}">Lượt xem: {{ number_format($song->luot_xem ?? 0) }}</span>
                            </div>
                            <span class="audio-duration">0:00 / 0:00</span>
                            <audio id="audio-{{ $song->id }}" src="{{ asset('storage/'. $song->file_amthanh) }}"></audio>
                            <button class="play-pause-button" data-song-id="{{ $song->id }}" data-audio-id="audio-{{ $song->id }}">
                                <i class='bx bx-play-circle'></i>
                            </button>
                            @php
                                $userLikedSongIds = auth()->check() ? auth()->user()->likedSongs->pluck('id')->toArray() : [];
                            @endphp
                            <button class="btn-like" data-song-id="{{ $song->id }}" style="background: transparent; border: none; font-size: 24px; color: white; cursor: pointer;">
                                {{ in_array($song->id, $userLikedSongIds) ? '♥' : '♡' }}
                            </button>
                        </li>
                    @empty
                        {{-- Không cần hiển thị gì nếu không có bài hát trong nửa sau --}}
                    @endforelse
                </ul>
            </div>
        </section>
    </main>

    @include('frontend.partials.right_content')
</div>

<script type='text/javascript' src="{{ asset('assets/frontend/js/songs.js') }}"></script>
<script type='text/javascript' src="script.js"></script>

</body>
</html>
