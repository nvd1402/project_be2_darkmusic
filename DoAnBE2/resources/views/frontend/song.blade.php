<!DOCTYPE html>
<html lang="en">
<head>@include('frontend.partials.head') </head>
<body class="text-light">>
<div class="container">
    <!-- Sidebar -->
    @include('frontend.partials.sidebar')
    <main>
        <!-- navLink -->
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
                @foreach($songs as $song)
                <ul class="songs-list" style="margin-bottom: 10px;">
                    <li class="songs-item">
                        @if($song->anh_daidien)
                            <img src="{{ asset('storage/' . $song->anh_daidien) }}" width="50" alt="images">
                        @else
                            Không có ảnh
                        @endif
                        <div style="margin-right: 100px">
                            <span>{{ $song->tenbaihat }}</span>
                            <br>
                            <small><span>{{ $song->artist->name_artist }}</span></small>
                        </div>
                        <span style="text-align: center">{{ $song->theloai }}</span>
                            <td>
                                @if($song->file_amthanh)
                                    <audio controls>
                                        <source src="{{ asset('storage/'.$song->file_amthanh) }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                @else
                                    <p>Không có âm thanh</p>
                                @endif
                            </td>
                    </li>
                </ul>
                @endforeach
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
</div>

<script type='text/javascript' src="script.js"></script>
</body>
</html>
