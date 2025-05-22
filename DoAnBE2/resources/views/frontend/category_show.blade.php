<!DOCTYPE html>
<html lang="vi">
<head>
    @include('frontend.partials.head')
    <title>Thể loại: {{ $category->tentheloai }}</title>
    <style>
        .container main {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            box-sizing: border-box;
            color: #fff;
        }

        .group-box {
            background: linear-gradient(145deg, #22223b, #1e1e2f);
            padding: 25px 20px 30px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
            color: #fff;
            display: flex;
            flex-direction: column;
            height: 250px;
            border-radius: 10px;
        }

        .group-title {
            font-size: 26px;
            font-weight: 700;
            color: #ffcc00;
            text-align: center;
            margin-bottom: 20px;
            user-select: none;
        }

        .carousel-container {
            position: relative;
            overflow: hidden;
            flex-grow: 1;
        }

        .carousel-track {
            display: flex;
            gap: 12px;
            transition: transform 0.4s ease;
            will-change: transform;
        }

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
            user-select: none;
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

        @media (max-width: 600px) {
            .group-box {
                height: auto;
            }
            .category-item {
                min-width: 140px;
            }
        }
         .banner {
        background-color: #2f3640;
        color: #f1f1f1;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
        height: 160px;
    }
    .artist-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
}

.artist-card {
    text-align: center;
    width: 140px;
}

.artist-card img {
    width: 100%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    transition: transform 0.3s ease;
}

.artist-card img:hover {
    transform: scale(1.05);
}
.nghesi {
    margin-top: 40px;
    padding: 20px;
    background: linear-gradient(135deg, #1e1e2f, #292942);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.4);
    color: #fff;
}

.nghesi > p {
    font-size: 28px;
    font-weight: 700;
    color: #ffcc00;
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
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    padding: 10px;
    text-align: center;
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
    user-select: none;
}

/* Responsive cho điện thoại */
@media (max-width: 600px) {
    .artist-card {
        width: 45vw;
        margin: 0 auto;
    }
    .artist-card img {
        height: 140px;
    }
    .nghesi > p {
        font-size: 22px;
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
         <div class="banner">Banner quảng cáo hoặc thông báo</div>

        <!-- Phần hiển thị group theo nhóm của thể loại hiện tại -->
        <section class="category-section">
            <div class="group-box" data-index="0">
                <h3 class="group-title">Các thể loại thuộc nhóm: {{ $category->nhom }}</h3>
                <div class="carousel-container">
                    <button class="carousel-btn btn-prev" data-index="0" aria-label="Prev">&lt;</button>
                    <ul class="carousel-track" id="carousel-track-0">
@foreach ($categoriesByNhom as $cat)
    <li class="category-item">
        <a href="{{ route('frontend.category_show', ['tentheloai' => $cat->tentheloai]) }}">
            {{ $cat->tentheloai }}
        </a>
    </li>
@endforeach

                    </ul>
                    <button class="carousel-btn btn-next" data-index="0" aria-label="Next">&gt;</button>
                </div>
            </div>
              <div class="nghesi">
    <p>Khám phá nghệ sĩ</p>

    <div class="artist-list" style="display: flex; flex-wrap: wrap; gap: 20px;">
        @foreach($artists as $artist)
            <div class="artist-card" style="text-align: center; width: 140px;">
                <img src="{{ asset('storage/' . $artist->image_artist) }}" alt="{{ $artist->name_artist }}" style="width: 100%; height: auto; border-radius: 10px;">
                <p style="margin-top: 8px; font-weight: bold;">{{ $artist->name_artist }}</p>
            </div>
        @endforeach
    </div>
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

        const itemWidth = 172;
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
</body>
</html>