<!DOCTYPE html>
<html lang="vi">
<head>
    @include('frontend.partials.head')
    <title>Thể loại</title>
    <style>
        body {
            background-color: #121212;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .category-section {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }

        .category-title {
            font-size: 28px;
            text-align: center;
            margin-bottom: 30px;
            color: #f1f1f1;
        }

        .category-list {
            list-style: none;
            padding: 0;
        }

        .category-item {
            background-color: #1e1e2f;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 18px;
            transition: background 0.2s ease;
        }

        .category-item:hover {
            background-color: #2f2f45;
        }
    </style>
</head>
<body>
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
                    <input type="text" placeholder="Tìm kiếm thể loại...">
                </div>
            </header>

            <!-- Danh sách thể loại -->
            <section class="category-section">
                <h2 class="category-title">Danh sách thể loại</h2>
                <ul class="category-list">
                    @foreach($categories as $category)
                        <li class="category-item">{{ $category->tentheloai }}</li>
                    @endforeach
                </ul>
            </section>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
