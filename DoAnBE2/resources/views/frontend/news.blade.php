<!DOCTYPE html>
<html lang="vi">
<head>
    @include('frontend.partials.head')
    <title>Tin tức</title>
    <style>
        body {
            background-color: #121212;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .news-list1 {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        .song-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            background-color: #1e1e2f;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            gap: 20px;
            transition: transform 0.2s ease;
        }

        .song-item:hover {
            transform: translateY(-4px);
        }

        .song-info {
            flex: 1;
        }

        .song-info span {
            font-style: italic;
            font-size: 14px;
            color: #ccc;
        }

        .song-info h3 {
            font-size: 20px;
            margin: 10px 0 8px;
            color: #f1f1f1;
        }

        .song-info p {
            font-size: 15px;
            color: #aaa;
        }

        .album-icon {
            width: 150px !important;
            height: 150px !important;
            
            object-fit: cover !important;
            
            border-radius: 0 !important;
            margin-left: 20px;
        }

        .btn1 {
            display: inline-block;
            margin-top: 10px;
            background-color: #ff4757;
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn1:hover {
            background-color: #e84118;
        }

        .genre-title {
            margin: 20px 0;
            font-size: 26px;
            font-weight: bold;
            text-align: center;
        }
        .container {
            width: 140%;
            padding: 0 40px;
            box-sizing: border-box;
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

            <div class="search">
                <i class='bx bx-search-alt-2'></i>
                <input type="text" placeholder="Tìm kiếm tin tức...">
            </div>
        </header>

        <!-- Danh sách tin tức -->
        <section class="genre-section">
            <div class="genre-tabs">
                <h2 class="genre-title">Tin tức mới nhất</h2>
            </div>

            <div class="genre-content">
        <ul class="news-list1" id="news-list-container">
    @foreach($news as $new)
        <li class="song-item news-item-js">
            <div class="song-info">
                <span class="donvidang">{{ $new->donvidang }}</span>
                <h3><a href="{{ route('frontend.news_show', ['id' => $new->id]) }}">{{ $new->tieude }}</a></h3>                          
                <p>{{ Str::limit($new->noidung, 350) }}</p>
            </div>
            <img src="{{ asset('storage/artists/' . $new->hinhanh) }}" alt="Hình ảnh" class="album-icon">
        </li>
    @endforeach
</ul>
            </div>
<div id="pagination-controls" style="margin-top: 15px; text-align: center;"></div>


        </section>
    </main>
</div>

<script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/news-pagination.js') }}"></script>

</body>
</html>