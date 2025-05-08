<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="frontend/style.css">
    <link rel="icon" href="./assets/free.zing.mp3.vip.reference_1.png" type="stylesheet" >
</head>
<body>
<aside class="sidebar">
            <div class="logo">
                <button class="menu-btn" id="menu-close">
                    <i class='bx bx-log-out-circle'></i>
                </button>
                <i class='bx bx-pulse'></i>
                <a>Dark Music</a>
            </div>
            <div class="menu">
                <ul>
                    <li>
                        <i class='bx bxs-bolt-circle'></i>
                        <a href="index.php">Khám phá</a>
                    </li>
                    
                    <li>
                        <i class='bx bxs-photo-album'></i>
                        <a href="rankings.php">Bảng xếp hạng</a>
                    </li>
                    <li>
                        <i class='bx bxs-microphone' ></i>
                        <a href="song.php">Bài hát</a>
                    </li>
                    <li>
                        <i class='bx bxs-microphone' ></i>
                        <a href="category.php">Thể loại</a>
                    </li>
                    <li>
                        <i class='bx bx-podcast' ></i>
                        <a>Ca sĩ </a>
                    </li>
                    <li>
                        <i class='bx bx-podcast' ></i>
                        <a>Play List </a>
                    </li>
                    <li>
                        <i class='bx bx-podcast' ></i>
                        <a>Yêu thích</a>
                    </li>
                    <li>
                        <i class='bx bx-podcast' ></i>
                        <a>Tin tức</a>
                    </li>
                 

                    <li class="volumne">
                        <i class='bx bx-volume-full' >                           
                        </i>
                        <a>Âm thanh</a>
                        <div class="playbar__volumne">
                            <i class='bx bxs-volume-full'></i>
                            <i class='bx bxs-volume-mute'></i>
                            <input type="range" class="volumne__amount" value="100" oninput="app.progressInput(this)">
                        </div>
                    </li>
                </ul>
            </div>

        </aside>
</body>
</html>