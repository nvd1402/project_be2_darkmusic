

<!DOCTYPE html>
<html lang="vi">
<head>
    @include('frontend.partials.head')
    <title>Tin tức</title>
    <style>




.container main {
    width: 150%;
    max-width: 1200px;
    margin: auto;
    padding: 20px;
    box-sizing: border-box;
}

.category-section {
    background-color: #1e1e2f;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    margin-top: 30px;
}

.category-title {
    font-size: 28px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
    color: #ffcc00;
}

.category-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.category-item a {
    display: block;
    background-color: #292942;
    padding: 15px 20px;
    border-radius: 10px;
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.3s ease, transform 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
}

.category-item a:hover {
    background-color: #3e3e60;
    transform: translateY(-3px);
}


.category-section {
    background-color: #1e1e2f;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    margin-top: 30px;
}

.category-title {
    font-size: 28px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
    color: #ffcc00;
}

.category-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.category-item a {
    display: block;
    background-color: #292942;
    padding: 15px 20px;
    border-radius: 10px;
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.3s ease, transform 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
}

.category-item a:hover {
    background-color: #3e3e60;
    transform: translateY(-3px);
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
                    <input type="text" placeholder="Tìm kiếm thể loại...">
                </div>
            </header>

            <!-- Danh sách thể loại -->
            <section class="category-section">
                <h2 class="category-title">Danh sách thể loại</h2>
                <ul class="category-list">
                    @foreach($categories as $category)
                       <li class="category-item">
    <a href="{{ route('frontend.category_show', ['id' => $category->id]) }}" style="color: inherit; text-decoration: none;">
        {{ $category->tentheloai }}
    </a>
</li>

                    @endforeach
                </ul>
            </section>
        </main>
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
