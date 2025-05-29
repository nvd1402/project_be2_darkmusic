<!DOCTYPE html>
<html lang="en">
<head>@include('frontend.partials.head')
    <style>
        /* CSS nội tuyến của bạn nếu có */
        /* ... giữ nguyên các style đã có cho body, container, main, header, search, v.v. ... */
        Tuyệt vời! Bạn muốn viết CSS cho phần topliked và cả phần featured-liked-song (bài hát nổi bật được thích nhất) nếu bạn muốn thêm nó vào. Dựa trên cấu trúc HTML và phong cách của trang web của bạn, tôi sẽ cung cấp CSS tương tự để phù hợp với giao diện tổng thể.

        Trước hết, bạn cần quyết định vị trí cho phần featured-liked-song nếu bạn muốn hiển thị nó. Ví dụ, bạn có thể đặt nó ngay dưới phần trending hoặc trên phần topliked.

        Tôi sẽ cung cấp CSS cho cả hai phần:

        featured-liked-song: Cho một bài hát duy nhất, nổi bật nhất (nếu bạn quyết định hiển thị nó).
                                                                                                    topliked: Cho danh sách các bài hát được thích nhiều nhất.
                                                                                                    Cập nhật frontend/index.blade.php (Phần CSS và HTML)
        Bạn sẽ đặt CSS này vào thẻ <style> trong phần <head> của file frontend/index.blade.php.

                                                                               HTML

        <!DOCTYPE html>
        <html lang="en">
        <head>
        @include('frontend.partials.head')
<style>
                 /* CSS nội tuyến của bạn nếu có */
                 /* ... giữ nguyên các style đã có cho body, container, main, header, search, v.v. ... */

                 /* CSS cho phần "Thể loại" (bao gồm cả cái cũ và cái mới) */
                 /* ... giữ nguyên phần CSS này ... */

                 /* Giữ nguyên CSS cho recommended-songs-scroll-container nếu bạn vẫn muốn nó cuộn */
                 /* ... giữ nguyên phần CSS này ... */

                 /* --- BỔ SUNG CSS MỚI CHO TOP LIKED SONGS --- */

                 /* CSS cho phần "Bài hát nổi bật được yêu thích nhất" (Featured Liked Song) */
             .featured-liked-song {
                 background-color: #384252; /* Màu nền tương tự các khối khác */
                 border-radius: 8px;
                 padding: 20px;
                 margin-top: 30px; /* Khoảng cách với phần trước đó */
                 display: flex;
                 align-items: center;
                 gap: 20px; /* Khoảng cách giữa các phần tử bên trong */
                 color: #E0E0E0;
                 box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                 transition: transform 0.2s ease-in-out;
                 cursor: pointer; /* Để tạo hiệu ứng hover như một card */
             }

        .featured-liked-song:hover {
            transform: translateY(-5px); /* Hiệu ứng nâng nhẹ khi hover */
        }

        .featured-liked-song .thumbnail {
            flex-shrink: 0; /* Đảm bảo hình ảnh không bị co lại */
        }

        .featured-liked-song .thumbnail img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .featured-liked-song .details {
            flex-grow: 1; /* Cho phép chi tiết bài hát chiếm không gian còn lại */
        }

        .featured-liked-song .details h3 {
            margin-top: 0;
            margin-bottom: 5px;
            color: #007bff; /* Màu xanh của tiêu đề bài hát */
            font-size: 22px; /* Kích thước lớn hơn cho bài hát nổi bật */
            white-space: nowrap; /* Ngăn không cho tên bài hát xuống dòng */
            overflow: hidden; /* Ẩn phần bị tràn */
            text-overflow: ellipsis; /* Hiển thị dấu ba chấm nếu tràn */
        }

        .featured-liked-song .details p {
            margin: 0;
            color: #b0b0b0;
            font-size: 15px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .featured-liked-song .like-info {
            display: flex;
            align-items: center;
            font-size: 18px; /* Kích thước lớn hơn cho thông tin lượt thích */
            color: #e74c3c; /* Màu đỏ cho lượt thích */
            margin-left: auto; /* Đẩy sang bên phải */
            flex-shrink: 0;
        }

        .featured-liked-song .like-info i {
            margin-right: 8px; /* Khoảng cách giữa icon và số */
        }

        /* CSS cho nút Play/Pause và thời lượng trong featured-liked-song */
        .featured-liked-song .song-audio {
            display: flex;
            align-items: center;
            margin-left: 20px; /* Khoảng cách từ like-info */
            flex-shrink: 0;
        }

        .featured-liked-song .song-audio .play-pause-button {
            background-color: #007bff; /* Nút play màu xanh */
            color: white;
            border: none;
            border-radius: 50%; /* Nút tròn */
            width: 45px; /* Kích thước nút */
            height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            font-size: 20px;
            transition: background-color 0.2s;
        }

        .featured-liked-song .song-audio .play-pause-button:hover {
            background-color: #0056b3;
        }

        .featured-liked-song .song-audio .audio-duration {
            margin-left: 10px;
            color: #b0b0b0;
            font-size: 14px;
        }


        /* --- CSS cho danh sách "Most Liked Songs" (Top Liked Songs) --- */
        .topliked {
            margin-top: 30px;
            background-color: #282828; /* Màu nền tương tự các khối khác */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .topliked .header h5 {
            color: #E0E0E0;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .topliked .songs-items-wrapper {
            display: flex;
            flex-direction: column; /* Sắp xếp các bài hát theo cột */
            gap: 15px; /* Khoảng cách giữa các bài hát */
        }

        .topliked .songs-item {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: #384252; /* Nền cho mỗi item bài hát */
            border-radius: 6px;
            transition: background-color 0.2s;
            cursor: pointer;
        }

        .topliked .songs-item:hover {
            background-color: #4c5a6d; /* Màu khi hover */
        }

        .topliked .song-thumbnail img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 15px;
        }

        .topliked .song-details {
            flex-grow: 1; /* Cho phép chi tiết bài hát chiếm không gian còn lại */
        }

        .topliked .song-details .nameArtist {
            color: #E0E0E0;
            font-size: 16px;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }

        .topliked .song-details small span {
            color: #b0b0b0;
            font-size: 12px;
        }

        .topliked .song-likes-count {
            display: flex;
            align-items: center;
            color: #e74c3c; /* Màu đỏ cho lượt thích */
            font-size: 14px;
            margin-left: 20px; /* Khoảng cách từ chi tiết bài hát */
            flex-shrink: 0;
        }

        .topliked .song-likes-count i {
            margin-right: 5px;
        }

        .topliked .song-audio {
            display: flex;
            align-items: center;
            margin-left: 20px; /* Khoảng cách từ lượt thích */
            flex-shrink: 0;
        }

        .topliked .song-audio .play-pause-button {
            background-color: transparent;
            color: #007bff; /* Nút play màu xanh */
            border: none;
            font-size: 18px;
            cursor: pointer;
            margin-right: 8px;
            transition: color 0.2s;
        }

        .topliked .song-audio .play-pause-button:hover {
            color: #0056b3;
        }

        .topliked .song-audio .audio-duration {
            color: #b0b0b0;
            font-size: 12px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .featured-liked-song {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            .featured-liked-song .thumbnail {
                margin-bottom: 10px;
            }
            .featured-liked-song .details h3 {
                font-size: 18px;
            }
            .featured-liked-song .like-info,
            .featured-liked-song .song-audio {
                margin-left: 0;
            }
            .topliked .songs-item {
                flex-wrap: wrap;
                justify-content: center;
                text-align: center;
            }
            .topliked .song-thumbnail {
                margin-right: 0;
                margin-bottom: 10px;
            }
            .topliked .song-details,
            .topliked .song-likes-count,
            .topliked .song-audio {
                width: 100%;
                justify-content: center;
                margin-left: 0;
            }
        }
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

        <div class="topliked">
            <div class="header">
                <h5>Most Liked Songs</h5>
            </div>
            <div class="songs-items-wrapper">
                @forelse ($mostLikedSongs as $song)
                    {{-- ... Code hiển thị danh sách Most Liked Songs (như bạn đã có) ... --}}
                    <div class="songs-list songs-item" data-song-id="{{ $song->id }}">
                        <div class="song-thumbnail">
                            @if($song->anh_daidien)
                                <img src="{{ asset('storage/' . $song->anh_daidien) }}" width="50" alt="{{ $song->tenbaihat }}">
                            @else
                                <img src="{{ asset('assets/frontend/images/default_song_50x50.png') }}" width="50" alt="no image">
                            @endif
                        </div>

                        <div class="song-details">
                            <span class="nameArtist">{{ $song->tenbaihat }}</span>
                            <br>
                            <small><span>{{ $song->artist->name_artist ?? 'Unknown Artist' }}</span></small>
                        </div>

                        <div class="song-likes-count">
                            <i class='bx bxs-heart'></i>
                            <span>{{ $song->users_who_liked_count ?? 0 }}</span>
                        </div>

                        <div class="song-audio">
                            <audio id="audio-mostliked-{{ $song->id }}" src="{{ asset('storage/'. $song->file_amthanh) }}"></audio>
                            <div class="audio-controls">
                                <button class="play-pause-button" data-audio-id="audio-mostliked-{{ $song->id }}">
                                    <i class="fas fa-play"></i>
                                </button>
                                <span class="audio-duration">0:00 / 0:00</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: #E0E0E0; text-align: center; padding: 20px;">Không có bài hát nào được yêu thích.</p>
                @endforelse
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
