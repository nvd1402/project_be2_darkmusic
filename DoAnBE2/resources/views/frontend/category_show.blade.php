<!DOCTYPE html>
<html lang="vi">
<head>
    @include('frontend.partials.head')
    <title>Thể loại: {{ $category->tentheloai }}</title>
    <style>
/* --- RESET & BASE --- */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Roboto", sans-serif;
}
body {
    background-color: #1a1a2e;
    color: #f0f0f0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.container {
    width: 140%;
    padding: 0 40px;
}
.container .sidebar {
    height: 105vh;
    background-color: #18181d;
        margin: 10px 0px 0px 0px;
    padding: 20px 30px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    z-index: 10000;
    transition: all 0.6s ease;
}

/* --- MAIN --- */
main {
    max-width: 1100px;
    margin: 40px auto;
    padding: 20px;
}

/* --- BANNER --- */
.banner {
    background-color: #2f3640;
    color: #f1f1f1;
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 60px;
    text-align: center;
    font-weight: bold;
    height: 160px;
}

/* --- GROUP BOX --- */
.group-box {
    background: linear-gradient(145deg, #22223b, #1e1e2f);
    padding: 25px 20px 30px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
    margin-bottom: 40px;
}
.group-title {
    font-size: 26px;
    font-weight: 700;
    color:rgb(255, 255, 255);
    text-align: center;
    margin-bottom: 20px;
    user-select: none;
}

/* --- CAROUSEL --- */
.carousel-container {
    position: relative;
    overflow: hidden;
}
.carousel-track {
    display: flex;
  gap: 60px;
    margin-left: 88px;
    transition: transform 0.4s ease;
    will-change: transform;
}
.category-item {
    min-width: 160px;
    flex-shrink: 0;
    list-style: none;
}
.category-item a {
    display: block;
    background-color: #292942;
    padding: 14px 18px;
    border-radius: 12px;
    color: #fff;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}
.category-item a:hover {
    background-color: #3e3e60;
    box-shadow: 0 6px 16px rgba(62, 62, 96, 0.7);
}

/* --- CAROUSEL BUTTONS --- */
.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: #ffcc00;
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 700;
    color: #222;
    box-shadow: 0 3px 8px rgba(0,0,0,0.3);
    opacity: 0.85;
    z-index: 10;
}
.carousel-btn:hover:not(:disabled) {
    opacity: 1;
}
.carousel-btn:disabled {
    opacity: 0.3;
    cursor: default;
}
.btn-prev {
    left: 8px;
}
.btn-next {
    right: 8px;
}

/* --- ARTISTS --- */
.nghesi {
    margin-top: 40px;
    padding: 20px;
    background: linear-gradient(135deg, #1e1e2f, #292942);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.4);
}
.nghesi > p {
    font-size: 28px;
    font-weight: 700;
    color:rgb(255, 255, 255);
    text-align: center;
    margin-bottom: 30px;
    user-select: none;
}
.artist-list {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
    justify-content: center;
}
.artist-card {
    background: #343454;
    width: 160px;
    border-radius: 14px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.3);
    padding: 10px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}
.artist-card:hover {
    transform: translateY(-8px) scale(1.05);
    box-shadow: 0 12px 28px rgba(255, 204, 0, 0.7);
}
.artist-card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    transition: transform 0.3s ease;
}
.artist-card img:hover {
    transform: scale(1.1);
}
.artist-card p {
    margin-top: 12px;
    font-weight: 600;
    font-size: 16px;
    color: #ffcc00;
}

/* --- SONGS --- */
.songs-list {
    margin-top: 40px;
    background: #292942;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
}
.songs-list h2 {
    font-size: 24px;
    color:rgb(255, 255, 255);
    margin-bottom: 20px;
}
.songs-list ul {
    list-style: none;
    padding-left: 0;
}
.songs-list li {
    padding: 10px 40px;
    border-bottom: 1px solid #444;
    font-size: 16px;
}

/* --- RESPONSIVE --- */
@media (max-width: 600px) {
    .group-box {
        height: auto;
    }
    .category-item {
        min-width: 140px;
    }
    .artist-card {
        width: 45vw;
    }
    .artist-card img {
        height: 140px;
    }
    .nghesi > p {
        font-size: 22px;
    }
    .songs-list h2 {
        font-size: 20px;
    }
}
.group-title1 {
    font-size: 18px;
    font-weight: 700;
    color: rgb(255, 0, 0);
    text-align: right;
    margin-bottom: 20px;
    user-select: none;
    float: right;
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
    </header>

    {{-- Banner quảng cáo --}}
    @if ($bannerAd)
    <div class="banner my-4 p-3 rounded shadow bg-light text-center">
        <a href="{{ $bannerAd->link_url }}" target="_blank" style="text-decoration: none; color: inherit;">
            <img src="{{ asset('storage/' . $bannerAd->media_type) }}"
                 alt="{{ $bannerAd->name }}"
                 style="max-width: 100%; max-height: 200px; object-fit: cover; border-radius: 8px;">
            <p class="mt-2">{{ $bannerAd->description }}</p>
        </a>
    </div>
    @endif
<h3 class="group-title">Tên loại nhạc {{ $category->tentheloai }}</h3>
<a href="{{ route('frontend.category')}}" class="group-title1">← Trở về trang thể loại</a>


    {{-- Section thể loại theo nhóm --}}
    <section class="category-section">
        <div class="group-box" data-index="0">
            <h3 class="group-title">Các thể loại thuộc nhóm: {{ $category->nhom }}</h3>
            <div class="carousel-container" style="position: relative; overflow: hidden;">
                <button class="carousel-btn btn-prev" data-index="0" aria-label="Prev" style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); z-index: 10;">&lt;</button>
                <ul class="carousel-track" id="carousel-track-0" style="display: flex; gap: 12px; padding: 0; margin: 0; list-style: none; transition: transform 0.3s ease;">
                    @foreach ($categoriesByNhom as $cat)
                    
                        <li class="category-item" style="min-width: 150px; flex-shrink: 0; text-align: center;">
                            <a href="{{ route('frontend.category_show', ['tentheloai' => $cat->tentheloai]) }}" style="text-decoration: none; color: inherit;">
                                @if ($cat->image)
                                    <img src="{{ asset('storage/category/' . $cat->image) }}" alt="{{ $cat->tentheloai }}" width="120" height="120" style="border-radius: 8px; object-fit: cover;">
                                @else
                                    <div style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; background-color: #f0f0f0; border-radius: 8px; font-size: 14px; color: #888;">Chưa có ảnh</div>
                                @endif
                                <div style="margin-top: 8px; font-weight: 600;">{{ $cat->tentheloai }}</div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <button class="carousel-btn btn-next" data-index="0" aria-label="Next" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); z-index: 10;">&gt;</button>
            </div>
        </div>

        {{-- Danh sách nghệ sĩ --}}
        <div class="nghesi" style="margin-top: 40px;">
            <p style="font-size: 18px; font-weight: bold; margin-bottom: 16px;">Khám phá nghệ sĩ</p>
            <div class="artist-list" style="display: flex; flex-wrap: wrap; gap: 20px;">
                @foreach($artists as $artist)
                    <div class="artist-card" style="text-align: center; width: 140px;">
                        <img src="{{ asset('storage/' . $artist->image_artist) }}" alt="{{ $artist->name_artist }}" style="width: 100%; height: 140px; object-fit: cover; border-radius: 10px;">
                        <p style="margin-top: 8px; font-weight: bold;">{{ $artist->name_artist }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Danh sách bài hát --}}
    <section class="songs-list" style="margin-top: 50px;">
        <h2>Bài hát thuộc thể loại: {{ $category->tentheloai }}</h2>
        @if ($songs->count() > 0)
            <ul>
                @foreach ($songs as $song)
                    <li><strong>{{ $song->tenbaihat }}</strong> - Nghệ sĩ: {{ $song->nghesi }}</li>
                @endforeach
            </ul>
        @else
            <p>Chưa có bài hát nào thuộc thể loại này.</p>
        @endif
    </section>
</main>

<script src="{{ asset('js/script.js') }}"></script>
<script>
    document.querySelectorAll('.group-box').forEach(group => {
        const index = group.dataset.index;
        const track = document.getElementById(`carousel-track-${index}`);
        const prevBtn = group.querySelector('.btn-prev');
        const nextBtn = group.querySelector('.btn-next');

        const itemWidth = 162; // Tổng kích thước 1 item + gap
        let visibleCount = Math.floor(group.querySelector('.carousel-container').offsetWidth / itemWidth);
        let totalItems = track.children.length;
        let maxIndex = Math.max(0, totalItems - visibleCount);
        let currentIndex = 0;

        function updateCarousel() {
            const offset = -currentIndex * itemWidth;
            track.style.transform = `translateX(${offset}px)`;
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= maxIndex;
        }

        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateCarousel();
            }
        });

        window.addEventListener('resize', () => {
            visibleCount = Math.floor(group.querySelector('.carousel-container').offsetWidth / itemWidth);
            maxIndex = Math.max(0, totalItems - visibleCount);
            currentIndex = 0;
            updateCarousel();
        });

        updateCarousel();
    });
</script>
