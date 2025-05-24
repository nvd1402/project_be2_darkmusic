<!DOCTYPE html>
<html lang="vi">
<head>
    @include('frontend.partials.head')
    <title>Tin tức</title>
    <style>/* Container chính */
.container main {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    box-sizing: border-box;
}

/* Phần nhóm thể loại */
.container-group {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-top: 30px;
}

.container {
    padding: 0 20px;
    box-sizing: border-box;
}


/* Box từng nhóm */
.group-box {
    background: linear-gradient(145deg, #1f1f2f, #2a2a40);
    border-radius: 20px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
    color: #fff;
    display: flex;
    flex-direction: column;
    height: 220px;
}

/* Tên nhóm */
.group-title {
    font-size: 22px;
    font-weight: 700;
    color: #ffffff;
    margin: 12px 0 4px 20px;
    letter-spacing: 1px;
    user-select: none;
}

/* Carousel */
.carousel-container {
    position: relative;
    overflow: hidden;
    flex-grow: 1;
    padding: 0 40px;
}

/* Track các thể loại */
.carousel-track {
    display: flex;
    gap: 14px;
    transition: transform 0.4s ease-in-out;
    will-change: transform;
}

/* Item category */
.category-item {
    min-width: 160px;
    flex-shrink: 0;
    list-style: none;
}

.category-item a {
    display: block;
    height: 170px;
    width: 250px;
    
    margin: 0 10px 0 40px;

    background-color: #373757;
    padding: 14px 18px;
    border-radius: 14px;
    color: #ffffff;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    user-select: none;
    transition: background-color 0.3s, transform 0.3s;
}

.category-item a:hover {
    background-color: #4b4b74;
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(80, 80, 120, 0.6);
}

/* Nút điều hướng */
.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.4);
    padding: 8px 14px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 700;
    color: #fff;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
    user-select: none;
    opacity: 0.7;
    transition: all 0.3s ease;
    z-index: 10;
    backdrop-filter: blur(5px);
}

.carousel-btn:hover:not(:disabled) {
    background-color: rgba(255, 255, 255, 0.35);
    opacity: 1;
    transform: translateY(-50%) scale(1.08);
}

.carousel-btn:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.btn-prev {
    left: 10px;
}

.btn-next {
    right: 10px;
}

/* Tiêu đề */
.category-title {
    color: #ffffff;
    text-align: center;
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Responsive */
@media (max-width: 900px) {
    .category-item {
        min-width: 140px;
    }

    .carousel-container {
        padding: 0 20px;
    }
}

@media (max-width: 600px) {
    .group-box {
        height: auto;
        padding-bottom: 20px;
    }

    .carousel-btn {
        display: none;
    }
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

        <!-- Danh sách thể loại theo nhóm -->
        <section class="category-section">
    <h2 class="category-title">Danh sách thể loại</h2>
    <div class="container-group">
        @foreach ($nhoms as $index => $nhom)
            <div class="group-box" data-index="{{ $index }}">
                <h3 class="group-title">{{ $nhom }}</h3>
                <div class="carousel-container">
                    <button class="carousel-btn btn-prev" data-index="{{ $index }}" aria-label="Prev">&lt;</button>
                    <ul class="carousel-track" id="carousel-track-{{ $index }}">
@foreach ($categoriesByNhom[$nhom] as $category)
    <li class="category-item">
        @if ($category->status) 
            <a href="{{ route('frontend.category_show', ['tentheloai' => $category->tentheloai]) }}">
                <img src="{{ asset('storage/category/' . $category->image) }}" alt="{{ $category->tentheloai }}" style="width: 100%; height: 100px; object-fit: cover; border-radius: 8px; margin-bottom: 8px;">
                <div style="font-weight: bold; color:rgb(255, 255, 255);">{{ $category->tentheloai }}</div>
            </a>
        @else
            <a href="javascript:void(0)" onclick="alert('Thể loại này hiện không hoạt động!')">
                <img src="{{ asset('storage/category/' . $category->image) }}" alt="{{ $category->tentheloai }}" style="width: 100%; height: 100px; object-fit: cover; border-radius: 8px; margin-bottom: 8px; opacity: 0.5;">
                <div style="font-weight: bold; color:rgb(255, 255, 255);">{{ $category->tentheloai }} (Đang khóa)</div>
            </a>
        @endif
    </li>
@endforeach

                    </ul>
                    <button class="carousel-btn btn-next" data-index="{{ $index }}" aria-label="Next">&gt;</button>
                </div>
            </div>
        @endforeach
    </div>
</section>

    </main>
</div>

<script src="{{ asset('js/script.js') }}"></script>
<script>
    document.querySelectorAll('.group-box').forEach(group => {
        const index = group.dataset.index;
        const track = document.getElementById(`carousel-track-${index}`);
        const prevBtn = group.querySelector('.btn-prev');
        const nextBtn = group.querySelector('.btn-next');

        const itemWidth = 172; // width + gap (160 + 12)
        const visibleCount = Math.floor(group.querySelector('.carousel-container').offsetWidth / itemWidth);
        const totalItems = track.children.length;
        const maxIndex = Math.max(0, totalItems - visibleCount);
        let currentIndex = 0;

        function updateCarousel() {
            const offset = -currentIndex * itemWidth;
            track.style.transform = `translateX(${offset}px)`;

            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= maxIndex;

            prevBtn.style.opacity = prevBtn.disabled ? 0.3 : 0.85;
            nextBtn.style.opacity = nextBtn.disabled ? 0.3 : 0.85;
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

        // Cập nhật lại visibleCount nếu resize cửa sổ
        window.addEventListener('resize', () => {
            const newVisibleCount = Math.floor(group.querySelector('.carousel-container').offsetWidth / itemWidth);
            if (newVisibleCount !== visibleCount) {
                currentIndex = 0; // reset vị trí khi resize
                updateCarousel();
            }
        });

        updateCarousel();
    });
</script>
</body>
</html>