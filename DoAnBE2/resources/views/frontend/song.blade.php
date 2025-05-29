<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('frontend.partials.head')

    <style>
        main {
            overflow-y: auto; /* Cho phép cuộn nếu nội dung dài */
            height: 100vh; /* Chiều cao đầy đủ để cuộn */
        }

        .heart-float {
            position: absolute;
            animation: floatUp 1s ease-out;
            font-size: 18px;
            color: red;
            pointer-events: none;
        }

        @keyframes floatUp {
            0% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translateY(-40px) scale(1.5);
            }
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

        <div class="songs-recommendations">
            <h2>Tất Cả Bài Hát</h2>
            <div id="songs-list-container">
                @foreach($songs as $song)
                    <div class="songs-list songs-item-js">
                        <li class="songs-item">
                            <div class="song-thumbnail">
                                @if($song->anh_daidien)
                                    <img src="{{ asset('storage/' . $song->anh_daidien) }}" width="50" alt="images">
                                @else
                                    <img src="https://via.placeholder.com/50" width="50" alt="no image"> @endif
                            </div>

                            <div class="song-details">
                                <span class="nameArtist">{{ $song->tenbaihat }}</span>
                                <br>
                                <small><span>{{ $song->artist->name_artist }}</span></small>
                            </div>

                            <div class="song-genre">
                                <span style="text-align: center; font-size:15px;">{{ $song->category ? $song->category->tentheloai : 'Không có thể loại' }}</span>
                            </div>


                            <div class="song-audio">
                                <audio id="audio-{{ $song->id }}" src="{{ asset('storage/'. $song->file_amthanh) }}"></audio>
                                <div class="audio-controls">
                                    <button class="play-pause-button " data-audio-id="audio-{{ $song->id }}">
                                        <i class="fas fa-play"></i> </button>
                      <span class="audio-duration">0:00 / 0:00
    <br>



</span>
<small class="view-count" data-song-id="{{ $song->id }}">
    Lượt xem: {{ $song->songView->views ?? 0 }}
</small>



                              
                                </div>
                            </div>
                            <div>
                                @php
                                    $likedSongs = $userLikedSongIds ?? [];
                                @endphp

                                <button class="btn-like" data-song-id="{{ $song->id }}" style="background: transparent; border: none; font-size: 24px; color: white; cursor: pointer;">
                                    {{ in_array($song->id, $likedSongs) ? '♥' : '♡' }}
                                </button>
                            </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-controls" id="pagination-controls">
            </div>
        </div>

        <div class="artist-trending">
            <h2>Các bản nhạc thịnh hành của 92914</h2>
            <ul class="songs-list">
                <li class="songs-item">
                    <span class="rank">1</span>
                    <img src="./assets/trend.png" alt="">
                    <span>Okinawa</span>
                    <span>5:48</span>
                </li>
                <li class="songs-item">
                    <span class="rank">2</span>
                    <img src="./assets/trend.png" alt="">
                    <span>Sunset</span>
                    <span>3:12</span>
                </li>
                <li class="songs-item">
                    <span class="rank">3</span>
                    <img src="./assets/trend.png" alt="">
                    <span>Koh</span>
                    <span>5:21</span>
                </li>
            </ul>
        </div>
        </section>
    </main>
    @include('frontend.partials.right_content')
</div>

<script type='text/javascript' src="script.js"></script>
<script type='text/javascript' src="{{ asset('assets/frontend/js/songs.js') }}"></script>





</body>
</html>
