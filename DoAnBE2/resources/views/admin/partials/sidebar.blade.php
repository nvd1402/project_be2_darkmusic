<aside class="sidebar">
    <div class="logo">
        <button class="menu-btn" id="menu-close">
            <i class='bx bx-log-out-circle'></i>
        </button>
        <i class='bx bx-pulse'></i>
        <a class="nameLogo" href="{{ route('admin.dashboard') }}">DarkMusic</a>
    </div>

    <div class="menu">
        <h5>Menu</h5>
        <ul>
            <li>
                <i class='bx bxs-bolt-circle'></i>
                <a href="{{ route('admin.users.index') }}">Quản lý người dùng</a>
            </li>
            <li>
                <i class='bx bxs-volume-full'></i>
                <a href="{{ route('admin.songs.index') }}">Quản lý bài hát</a>
            </li>
            <li>
                <i class='bx bxs-album'></i>
                <a href="#">Quản lý thể loại</a>
            </li>
            <li>
                <i class='bx bxs-microphone'></i>
                <a href="{{ route('admin.artist.index') }}">Quản lý nghệ sĩ</a>
            </li>
            <li>
                <i class='bx bxs-radio'></i>
                <a href="#">Quản lý album</a>
            </li>
            <li>
                <i class='bx bx-undo'></i>
                <a href="#">Quản lý tin tức</a>
            </li>
            <li>
                <i class='bx bxs-photo-album'></i>
                <a href="#">Quản lý quảng cáo</a>
            </li>
            <li>
                <i class='bx bxs-heart'></i>
                <a href="{{ route('admin.revenue.index') }}">Quản lý doanh thu</a>
            </li>
            <li>
                <i class='bx bxs-folder'></i>
                <a href="#">Local</a>
            </li>
        </ul>
    </div>

    <div class="playing">
        <div class="top">
            <img src="assets/current.png">
            <h4>Apple<br>Homepod</h4>
        </div>
        <div class="bottom">
            <i class='bx bx-podcast'></i>
            <p>Playing On Device</p>
        </div>
    </div>


</aside>
