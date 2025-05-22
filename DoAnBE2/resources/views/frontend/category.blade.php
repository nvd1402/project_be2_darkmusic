<!DOCTYPE html>
<html lang="vi">
<head>
    @include('frontend.partials.head')
    <title>Tin tức</title>
    <style>
        /* Container chính */
        .container main {
            max-width: 1200px;
            margin: 0px auto;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Phần nhóm thể loại */
   .container-group {
    display: flex;
    flex-direction: column; /* cho mỗi nhóm 1 dòng theo chiều dọc */
    gap: 20px;
    margin-top: 30px; 
}


        .group-box {
            background: linear-gradient(145deg, #22223b, #1e1e2f);
          
       
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
            color: #fff;
            display: flex;
            flex-direction: column;
            height: 150px;
        }

        .group-title {
            font-size: 24px;
            font-weight: 700;
            color: #ffcc00;
            text-align: center;
            margin-bottom: 22px;
            letter-spacing: 1.2px;
            user-select: none;
        }

        /* Carousel container */
        .carousel-container {
            position: relative;
            overflow: hidden;
            flex-grow: 1;
        }

        /* Track chứa các category */
        .carousel-track {
            display: flex;
            gap: 12px;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }

        /* Item category */
        .category-item {
            min-width: 160px;
            list-style: none;
            flex-shrink: 0;
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
            box-shadow: 0 4px 10px rgb(0 0 0 / 0.3);
            user-select: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .category-item a:hover {
            background-color: #3e3e60;
            box-shadow: 0 6px 16px rgba(62, 62, 96, 0.7);
        }

        /* Nút điều hướng carousel */
        .carousel-btn {
            position: absolute;
            top: 70%;
            transform: translateY(-50%);
            background-color: #ffcc00;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            color: #222;
            box-shadow: 0 3px 8px rgba(0,0,0,0.3);
            user-select: none;
            opacity: 0.85;
            transition: opacity 0.3s ease;
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

        /* Responsive: giảm số item hiển thị */
        @media (max-width: 900px) {
            .container-group {
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            }
            .category-item {
                min-width: 140px;
            }
        }

        @media (max-width: 600px) {
            .container-group {
                grid-template-columns: 1fr;
            }
            .group-box {
                height: auto;
            }
        }
        .category-title{
            color:rgb(255, 255, 255);
            text-align: center;
            justify-content: center;
            align-items: center;
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


<a href="{{ route('frontend.category_show', ['tentheloai' => $category->tentheloai]) }}">
    {{ $category->tentheloai }}
</a>




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