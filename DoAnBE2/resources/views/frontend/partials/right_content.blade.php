<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="./assets/free.zing.mp3.vip.reference_1.png" type="stylesheet" >
    <title>Document</title>
</head>
<body>
<div class="right-section">
            <!-- Profile -->

            <div class="profile">
                <div class="user">

                    <div class="right">
                        <h5>Nâng cấp tài khoản</h5>
                    </div>
                </div>
                <i class='bx bxs-bell'></i>
                <i class='bx bxs-cog' ></i>
                <div class="d-flex align-items-center">
                    @guest
                        <a href="{{ route('login') }}" class="text-decoration-none me-3">
                            <div class="user">
                                <div class="left"><img src="" alt=""></div>
                                <div class="right"><h5>Đăng nhập</h5></div>
                            </div>
                        </a>
                    @endguest

                    @auth
                        <a href="{{ route('profile') }}" class="text-decoration-none me-3">
                            <div class="user d-flex align-items-center">
                                <div class="left me-2">
                                    <img src="{{ Auth::user()->avatar
                        ? asset('storage/'.Auth::user()->avatar)
                        : '/default-avatar.png'
                    }}"
                                         alt="avatar"
                                         class="rounded-circle"
                                         width="40">
                                </div>
                                <div class="right">
                                    <h5 class="mb-0">{{ Auth::user()->username }}</h5>
                                </div>
                            </div>
                        </a>


                    @endauth
                </div>
            </div>

            <!-- Music player -->
            <div class="music-player">
                <div class="top-section">
                    <div class="header">
                        <h5>Player</h5>
                        <i class='bx bxs-playlist'></i>
                    </div>
                    <div class="song-info">
                        <div class="cd">
                            <div class="cd-thumb"></div>
                            <!-- <img src="assets/player.png" alt=""> -->
                        </div>
                        <div class="description">
                            <h3>Ripple Echoes</h3>
                            <!-- <h5>Kael Fischer</h5> -->
                            <p>Best of 2024</p>
                        </div>
                        <div class="time">
                            <p class="time-start">0:00</p>
                            <input id="progress" class="progress" type="range" value="0" step="1" min="0" max="100">
                            <!-- <p class="start">02:45</p>
                            <div class="active-line"></div>
                            <div class="deactive-line"></div>
                            <p class="end">01:02</p> -->
                            </input>
                            <p class="time-end">0:00</p>
                        </div>


                        <audio id="audio" src=""></audio>

                    </div>
                </div>

                <div class="player-actions">
                    <div class="buttons">
                        <div class="btn btn-repeat">
                            <i class='bx bx-repeat'></i>
                            <i class='bx bx-atom'></i>
                        </div>
                        <div class="btn btn-prev">
                            <i class='bx bx-skip-previous'></i>
                        </div>
                        <div class="btn btn-toggle-play play-toggle">
                            <i class='bx bx-play play-button'></i>
                            <i class='bx bx-pause play-pause'></i>
                        </div>
                        <div class="btn btn-next">
                            <i class='bx bx-skip-next' ></i>
                        </div>
                        <div class="btn btn-random">
                            <i class='bx bx-transfer-alt' ></i>
                          </div>
                    </div>

                    <div class="lyrics">
                        <i class='bx bx-chevron-up' ></i>
                        <i class='bx bx-chevron-down'></i>
                        <h5>Lyrics</h5>
                        <div class="lyrics-song hidden">
                            <div class="lyrics-song__name">

                            </div>
                            <div class="lyrics-songs">
                                ${formatLyrics(song.lyrics)}
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <script type='text/javascript' src="script.js"></script>
</body>
</html>
