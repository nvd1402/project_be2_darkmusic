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
        <!-- BXH Nhac Moi -->
        <section class="bxh-nhac-moi">
            <h2 class="title">BXH Nhạc Mới <i class='bx bx-play-circle'></i></h2>
            <div class="song-columns">
                <ul class="song-list">
                    <li class="song-item">
                        <span class="rank">1</span>
                        <img src="./assets/trend.png" alt="01 Ngoại Lệ">
                        <div class="song-info">
                            <h3>01 Ngoại Lệ</h3>
                            <p>Jack - J97</p>
                        </div>
                        <span class="duration">04:44</span>
                    </li>
                    <li class="song-item">
                        <span class="rank">2</span>
                        <img src="./assets/song-2.png" alt="Hoang Tưởng">
                        <div class="song-info">
                            <h3>Hoang Tưởng</h3>
                            <p>Hào JK</p>
                        </div>
                        <span class="duration">04:50</span>
                    </li>
                    <li class="song-item active">
                        <span class="rank">3 <span class="up">▲</span></span>
                        <img src="./assets/song3.jpg" alt="BIGTEAM BIGDREAM">
                        <div class="song-info">
                            <h3>BIGTEAM BIGDREAM</h3>
                            <p>BIGTEAM All Stars, BigDaddy, HURRYKNG, Pháp Kiều, Tez, gung0cay...</p>
                        </div>
                        <span class="duration">08:50</span>
                    </li>
                    <li class="song-item">
                        <span class="rank">4</span>
                        <img src="./assets/song4.jpg" alt="Ta Tựa Vào Ta">
                        <div class="song-info">
                            <h3>Ta Tựa Vào Ta</h3>
                            <p>Lưu Hưng</p>
                        </div>
                        <span class="duration">04:37</span>
                    </li>
                    <li class="song-item">
                        <span class="rank">5 <span class="down">▼</span></span>
                        <img src="./assets/song5.jpg" alt="Thật lòng">
                        <div class="song-info">
                            <h3>Thật lòng</h3>
                            <p>Nguyên</p>
                        </div>
                        <span class="duration">03:17</span>
                    </li>
                </ul>
                <ul class="song-list">
                    <li class="song-item">
                        <span class="rank">6 <span class="down">▼</span></span>
                        <img src="./assets/song6.jpg" alt="Cho con là Người Việt Nam">
                        <div class="song-info">
                            <h3>Cho con là Người Việt Nam</h3>
                            <p>Tùng Dương, MANBO</p>
                        </div>
                        <span class="duration">05:26</span>
                    </li>
                    <li class="song-item">
                        <span class="rank">7</span>
                        <img src="./assets/song7.jpg" alt="Tóc Em Ướt Rồi">
                        <div class="song-info">
                            <h3>Tóc Em Ướt Rồi</h3>
                            <p>MYLINA</p>
                        </div>
                        <span class="duration">03:13</span>
                    </li>
                    <li class="song-item">
                        <span class="rank">8</span>
                        <img src="./assets/song8.jpg" alt="Bài Hát 8">
                        <div class="song-info">
                            <h3>Bài Hát 8</h3>
                            <p>Ca sĩ 8</p>
                        </div>
                        <span class="duration">04:12</span>
                    </li>
                    <li class="song-item">
                        <span class="rank">9</span>
                        <img src="./assets/song9.jpg" alt="Bài Hát 9">
                        <div class="song-info">
                            <h3>Bài Hát 9</h3>
                            <p>Ca sĩ 9</p>
                        </div>
                        <span class="duration">04:20</span>
                    </li>
                    <li class="song-item">
                        <span class="rank">10</span>
                        <img src="./assets/song10.jpg" alt="Bài Hát 10">
                        <div class="song-info">
                            <h3>Bài Hát 10</h3>
                            <p>Ca sĩ 10</p>
                        </div>
                        <span class="duration">03:45</span>
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
