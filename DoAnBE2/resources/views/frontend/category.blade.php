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
        <!-- Làm trong này -->
        <section class="genre-section">
            <div class="genre-tabs">
                <button class="genre-btn active">Pop</button>
                <button class="genre-btn">Rap</button>
                <button class="genre-btn">Indie</button>
                <button class="genre-btn">Ballad</button>
                <button class="genre-btn">Rock</button>
                <button class="genre-btn">R&B</button>
                <button class="genre-btn">Jazz</button>
            </div>

            <div class="genre-content">
                <h2 class="genre-title">Pop</h2>
                <ul class="song-list">
                    <li class="song-item">
                        <span class="rank">1</span>
                        <img src="./assets/song1.jpg" alt="Ai Ma Biết Được I Tình" class="album-icon">
                        <div class="song-info">
                            <h3>Ai Ma Biết Được I Tình</h3>
                            <p>Soobin Hoàng Sơn</p>
                        </div>
                        <button class="play-btn"><i class='bx bx-play'></i></button>
                        <button class="like-btn"><i class='bx bx-heart'></i></button>
                        <button class="add-btn"><i class='bx bx-plus'></i></button>
                    </li>
                    <li class="song-item">
                        <span class="rank">2</span>
                        <img src="./assets/song2.jpg" alt="Bật Nổ Lên" class="album-icon">
                        <div class="song-info">
                            <h3>Bật Nổ Lên</h3>
                            <p>Soobin Hoàng Sơn</p>
                        </div>
                        <button class="play-btn"><i class='bx bx-play'></i></button>
                        <button class="like-btn"><i class='bx bx-heart'></i></button>
                        <button class="add-btn"><i class='bx bx-plus'></i></button>
                    </li>
                    <li class="song-item">
                        <span class="rank">3</span>
                        <img src="./assets/song3.jpg" alt="Beautiful Nightmare (Interlude)" class="album-icon">
                        <div class="song-info">
                            <h3>Beautiful Nightmare (Interlude)</h3>
                            <p>Amee</p>
                        </div>
                        <button class="play-btn"><i class='bx bx-play'></i></button>
                        <button class="like-btn"><i class='bx bx-heart'></i></button>
                        <button class="add-btn"><i class='bx bx-plus'></i></button>
                    </li>
                    <li class="song-item">
                        <span class="rank">4</span>
                        <img src="./assets/song4.jpg" alt="Bình Minh Rơi Đằng Tây" class="album-icon">
                        <div class="song-info">
                            <h3>Bình Minh Rơi Đằng Tây</h3>
                            <p>14 Casper & Bon Nghiêm</p>
                        </div>
                        <button class="play-btn"><i class='bx bx-play'></i></button>
                        <button class="like-btn"><i class='bx bx-heart'></i></button>
                        <button class="add-btn"><i class='bx bx-plus'></i></button>
                    </li>
                    <li class="song-item">
                        <span class="rank">5</span>
                        <img src="./assets/song5.jpg" alt="Cuộc Gọi Lúc Nửa Đêm" class="album-icon">
                        <div class="song-info">
                            <h3>Cuộc Gọi Lúc Nửa Đêm</h3>
                            <p>Amee</p>
                        </div>
                        <button class="play-btn"><i class='bx bx-play'></i></button>
                        <button class="like-btn"><i class='bx bx-heart'></i></button>
                        <button class="add-btn"><i class='bx bx-plus'></i></button>
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
