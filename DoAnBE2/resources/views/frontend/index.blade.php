<!DOCTYPE html>
<html lang="en">
<head>@include('frontend.partials.head')
    <style>
        /* CSS nội tuyến của bạn nếu có */
        /* ... giữ nguyên các style đã có cho body, container, main, header, search, v.v. ... */

        /* CSS cho phần "Thể loại" (bao gồm cả cái cũ và cái mới) */
        .genres .header h5 {
            color: #E0E0E0; /* Màu chữ tiêu đề */
            font-size: 18px;
            margin-bottom: 15px;
        }

        .genres .items {
            display: flex;
            flex-wrap: wrap; /* Cho phép các mục xuống dòng */
            gap: 10px; /* Khoảng cách giữa các mục thể loại */
            background-color: #282828; /* Màu nền cho box tổng */
            padding: 20px; /* Khoảng đệm bên trong box */
            border-radius: 8px; /* Bo góc box */
        }

        .genres .item {
            background-color: #384252; /* Màu nền cho mỗi nút thể loại, giống màu xanh đậm trong ảnh */
            border-radius: 5px;
            padding: 8px 15px;
            font-size: 14px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .genres .item:hover {
            background-color: #4c5a6d; /* Màu khi hover */
        }

        .genres .item p {
            margin: 0;
        }

        .genres .item a {
            color: #E0E0E0; /* Màu chữ cho liên kết bên trong nút */
            text-decoration: none;
        }
        .genres .item a:hover {
            text-decoration: underline;
        }

        /* Giữ nguyên CSS cho recommended-songs-scroll-container nếu bạn vẫn muốn nó cuộn */
        .recommended-songs-scroll-container {
            max-height: 300px;
            overflow-y: auto;
            padding-right: 10px;
        }
        .recommended-songs-scroll-container::-webkit-scrollbar { width: 8px; }
        .recommended-songs-scroll-container::-webkit-scrollbar-track { background: #282828; border-radius: 10px; }
        .recommended-songs-scroll-container::-webkit-scrollbar-thumb { background: #555; border-radius: 10px; }
        .recommended-songs-scroll-container::-webkit-scrollbar-thumb:hover { background: #888; }

    </style>
</head>
<body>
@empty(!$ads)
    <div class="banner-wrapper">
        <div class="banner-container">
            @forelse ($ads as $index => $ad)
                <div class="banner-slide {{ $index === 0 ? 'active' : '' }}">
                    @php
                        $ext = pathinfo($ad->media_type, PATHINFO_EXTENSION);
                    @endphp

                    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                        <a href="{{ $ad->link_url }}" target="_blank">
                            <img src="{{ asset('storage/' . $ad->media_type) }}" class="image-ad card-img-top" alt="Banner {{ $index + 1 }}">
                        </a>
                    @endif
                </div>
            @empty
                <p>Không có quảng cáo nào.</p>
            @endforelse
        </div>
    </div>
@endempty
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
        <div class="trending">
            <div class="left">
                <h5>Trending New Song</h5>
                <div class="info">
                    {{-- HIỂN THỊ BÀI HÁT MỚI NHẤT Ở ĐÂY --}}
                    @if ($latestSong)
                        <h2>{{ $latestSong->tenbaihat }}</h2>
                        <h4>{{ $latestSong->artist->name_artist ?? 'Unknown Artist' }}</h4>
                        <div class="buttons-action">
                            @if ($latestSong)
                                <audio id="trending-audio" src="{{ asset('storage/' . $latestSong->file_amthanh) }}" preload="metadata"></audio>
                                <div class="audio-controls">
                                    <button class="play-pause-button" data-audio-id="trending-audio">Listen Now</button>
                                </div>
                            @else
                                <button class="listen" disabled>Listen Now</button>
                                <button class="stop" disabled>Stop Now</button>
                            @endif
                            <i class='bx bxs-heart' ></i>
                            <i class='bx bx-heart'></i>
                        </div>
                    @else
                        <p>No trending song available.</p>
                    @endif
                </div>
            </div>
            <div class="waves">
                <span class="wave paused" style="width: 0px;"></span>
                <span class="wave paused" style="width: 0px;"></span>
                <span class="wave paused" style="width: 0px;"></span>
                <span class="wave paused" style="width: 0px;"></span>
                <span class="wave paused" style="width: 0px;"></span>
                <span class="wave paused" style="width: 0px;"></span>
                <span class="wave paused" style="width: 0px;"></span>
            </div>
            <div class="left-img">
                {{-- HIỂN THỊ ẢNH ĐẠI DIỆN BÀI HÁT MỚI NHẤT --}}
                @if ($latestSong && $latestSong->anh_daidien)
                    <img src="{{ asset('storage/' . $latestSong->anh_daidien) }}" style="height: 200px; width: 300px; object-fit: cover;" alt="{{ $latestSong->tenbaihat }}">
                @else
                    {{-- Đặt ảnh mặc định nếu không có --}}
                    <img src="{{ asset('assets/frontend/images/default_trend_song.png') }}" style="height: 200px; width: 300px; object-fit: cover;" alt="Default Trending Song">
                @endif
            </div>

        </div>
        <div class="playlist">
            <div class="genres">
                <div class="header">
                    <h5>Top 5 thể loại mới nhất</h5>
                </div>

                <div class="items">
                    @forelse($latestCategories as $category)
                        <div class="item">
                            <p>
{{--                                <a href="{{ route('frontend.category_show', ['tentheloai' => $category->tentheloai]) }}">--}}
                                <a href="{{ route('frontend.category_show', ['tentheloai' => $category->tentheloai]) }}">{{ $category->tentheloai }}</a></p>
                            <div class="music-items__list">
                            </div>
                        </div>
                    @empty
                        <p>Không có thể loại mới nào được tìm thấy.</p>
                    @endforelse
                    <div class="item period">
                        <p>Classical Period</p>
                        <div class="music-items__list">
                        </div>
                    </div>
                </div>
            </div>

            <div class="music-list">
                <div class="header">
                    <h5>Đề Xuất</h5>
                </div>
                {{-- THAY ĐỔI Ở ĐÂY: Thêm một div với class 'recommended-songs-scroll-container' --}}
                <div class="recommended-songs-scroll-container">
                    {{-- HIỂN THỊ DANH SÁCH BÀI HÁT ĐỀ XUẤT --}}
                    @forelse ($recommendedSongs as $song)
                        <div class="songs-list songs-item" data-song-id="{{ $song->id }}">
                            <li class="songs-item">
                                <div class="song-thumbnail">
                                    @if($song->anh_daidien)
                                        <img src="{{ asset('storage/' . $song->anh_daidien) }}" width="50" alt="{{ $song->tenbaihat }}">
                                    @else
                                        <img src="{{ asset('assets/frontend/images/default_song_50x50.png') }}" width="50" alt="no image"> {{-- Đặt ảnh mặc định phù hợp --}}
                                    @endif
                                </div>

                                <div class="song-details">
                                    <span class="nameArtist" style="color: #007bff;">{{ $song->tenbaihat }}</span>
                                    <br>
                                    {{-- Sử dụng $song->artist->name_artist như bạn đã dùng --}}
                                    <small><span  style="font-size:10px;">{{ $song->artist->name_artist ?? 'Unknown Artist' }}</span></small>
                                </div>

                                <div class="song-genre">
                                    {{-- Sử dụng $song->category->tentheloai như bạn đã dùng --}}
                                    <span style="text-align: center; font-size:15px;">{{ $song->category->tentheloai ?? 'Không có thể loại' }}</span>
                                </div>

                                <div class="song-audio">
                                    <audio id="audio-{{ $song->id }}" src="{{ asset('storage/'. $song->file_amthanh) }}"></audio>
                                    <div class="audio-controls">
                                        <button class="play-pause-button" data-audio-id="audio-{{ $song->id }}">
                                            <i class="fas fa-play"></i> </button>
                                        <span class="audio-duration">0:00 / 0:00</span>
                                    </div>
                                </div>
                            </li>
                        </div>
                    @empty
                        <p>Không có bài hát đề xuất nào.</p>
                    @endforelse
                </div> {{-- Đóng div.recommended-songs-scroll-container --}}
            </div>
        </div>

        <div class="box-artist">
            <div class="list-artist">
                @foreach ($artists as $artist)
                    <div class="artist">
                        <img src="{{ asset('storage/artists/' . $artist->image_artist) }}" alt="{{ $artist->name_artist }}" class="image-artist">
                        <h3 class="title-artist">{{ $artist->name_artist }}</h3>
                        <span class="text-artist">Artist</span>
                    </div>
                @endforeach
            </div>
        </div>

    </main>


    @include('frontend.partials.right_content')
</div>
</div>

<script src="https://kit.fontawesome.com/your-font-awesome-kit-id.js" crossorigin="anonymous"></script>
<script type='text/javascript'>
    // Truyền dữ liệu recommendedSongs từ Blade sang JavaScript
    window.recommendedSongsData = @json($recommendedSongs);
    // Truyền dữ liệu latestSong từ Blade sang JavaScript (nếu cần cho các tính năng khác trong script.js)
    window.latestSongData = @json($latestSong);
</script>
<script type='text/javascript' src="{{ asset('assets/frontend/js/script.js') }}"></script>
<script type='text/javascript' src="{{ asset('assets/frontend/js/audio-controls.js') }}"></script>
<script src="{{ asset('assets/frontend/js/handle-ad.js') }}"></script>
<script type='text/javascript' src="{{ asset('assets/frontend/js/songs.js') }}"></script>
</body>
</html>
