<!DOCTYPE html>
<html lang="en">
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
                <a href="{{ route('frontend.home') }}">Khám phá</a>
            </li>

            <li>
                <i class='bx bxs-photo-album'></i>
                <a href="{{ route('frontend.rankings') }}">Bảng xếp hạng</a>
            </li>
            <li>
                <i class='bx bxs-microphone' ></i>
                <a href="{{ route('frontend.song', ['slug' => 'some-song-slug']) }}">Bài hát</a>
                {{-- Lưu ý: Đối với trang bài hát, bạn cần truyền một slug thực tế hoặc điều chỉnh route nếu nó không yêu cầu slug --}}
            </li>
            <li>
                <i class='bx bxs-microphone' ></i>
                <a href="{{ route('frontend.category', ['slug' => 'some-category-slug']) }}">Thể loại</a>
                {{-- Lưu ý: Đối với trang thể loại, bạn cần truyền một slug thực tế hoặc điều chỉnh route nếu nó không yêu cầu slug --}}
            </li>
            <li>
                <i class='bx bx-podcast' ></i>
                <a>Ca sĩ </a>
                {{-- Bạn cần định nghĩa route và controller cho Ca sĩ nếu muốn liên kết --}}
            </li>
            <li>
                <i class='bx bx-podcast' ></i>
                <a>Play List </a>
                {{-- Bạn cần định nghĩa route và controller cho Play List nếu muốn liên kết --}}
            </li>
            <li>
                <i class='bx bx-podcast' ></i>
                <a>Yêu thích</a>
                {{-- Bạn cần định nghĩa route và controller cho Yêu thích nếu muốn liên kết --}}
            </li>
            <li>
                <i class='bx bx-podcast' ></i>
                <a>Tin tức</a>
                {{-- Bạn cần định nghĩa route và controller cho Tin tức nếu muốn liên kết --}}
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
