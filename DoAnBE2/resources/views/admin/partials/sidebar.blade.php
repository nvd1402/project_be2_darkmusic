<aside class="sidebar">
    <div class="logo">
        <button class="menu-btn" id="menu-close">
            <i class='bx bx-log-out-circle'></i>
        </button>
        <i class='bx bx-pulse'></i>
        <a class="nameLogo" href="{{ route('admin.dashboard') }}">DarkMusic</a>
    </div>

    <div class="menu">
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
                <a href="{{ route('admin.categories.index') }}">Quản lý thể loại</a>

            </li>
            <li>
                <i class='bx bxs-microphone'></i>
                <a href="{{ route('admin.artist.index') }}">Quản lý nghệ sĩ</a>
            </li>
            <li>
                <i class='bx bxs-radio'></i>
                                <a href="{{ route('admin.album.index') }}">Quản lý album</a>
            </li>
            <li>

            <i class='bx bxs-album'></i>
                <a href="{{ route('admin.news.index') }}">Quản lý tin tức</a>
            </li>
            <li>
                <i class='bx bxs-photo-album'></i>
                <a href="{{ route('admin.ad.index') }}">Quản lý quảng cáo</a>
            </li>
            <li>
                <i class='bx bxs-heart'></i>
                <a href="{{ route('admin.revenue.index') }}">Quản lý doanh thu</a>
            </li>
                        <li>

                            <i class='bx bxs-comment'></i>

                <a href="{{ route('admin.comments.index') }}">Quản lý bình luận </a>
            </li>
            <li>
                <i class='bx bxs-folder'></i>
                <a href="#">Local</a>
            </li>
        </ul>
    </div>




</aside>
