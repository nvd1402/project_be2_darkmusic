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
        <section class="songs-detail">
            <div class="songs-header">
                <img src="./assets/trend.png" alt="Sunset Album Cover" class="album-cover">
                <div class="songs-info">
                    <h1>Sunset</h1>
                    <p>92914</p>
                    <div class="songs-actions">
                        <button class="play-btn">
                            <i class='bx bx-play'></i>
                        </button>
                        <button class="add-btn">
                            <i class='bx bx-plus'></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="songs-recommendations">
                <h2>Đề xuất</h2>
                <ul class="songs-list">
                    <li class="songs-item">
                        <img src="./assets/trend.png" alt="">
                        <span>free love - dream edit</span>
                        <span>4:12</span>
                    </li>
                    <li class="songs-item">
                        <img src="./assets/trend.png" alt="">
                        <span>Colors Of You</span>

                        <span>3:02</span>
                    </li>
                    <li class="songs-item">
                        <img src="./assets/trend.png" alt="">
                        <span>Lemonade</span>

                        <span>5:12</span>
                    </li>
                    <li class="songs-item">
                        <img src="./assets/trend.png" alt="">
                        <span>Grace</span>

                        <span>2:13</span>
                    </li>
                </ul>
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
