<!DOCTYPE html>
<html lang="vi">
<head>
    @include('frontend.partials.head')
    <title>{{ $news->tieude }}</title>
<style>
    body {
        background-color: #121212;
        color: #fff;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

.container main {
    padding: 20px 36px;
    max-width: max-content;
    width: 153%;
}
    .container {
        max-width: 140%;
        margin: auto;
        padding: 20px;
        box-sizing: border-box;
    }

    .content-wrapper {
        display: flex;
        gap: 30px;
        margin-top: 30px;
    }

    .news-content {
        flex: 3;
        background-color: #1e1e2f;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    }

    .news-title {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #f1f1f1;
    }

    .news-unit {
        font-style: italic;
        color: #ccc;
        margin-bottom: 20px;
    }

    .news-image {
        width: 100%;
        max-height: 450px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
    }

    .news-body {
        font-size: 18px;
        line-height: 1.7;
        color: #ddd;
        white-space: pre-wrap;
    }

    .btn-back {
        display: inline-block;
        margin-top: 30px;
        background-color: #ff4757;
        color: #fff;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .btn-back:hover {
        background-color: #e84118;
    }

    .related-news {
        flex: 1.2;
        background-color: #1a1a2a;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        overflow-y: auto;
        max-height: 800px;
    }

    .related-news h2 {
        font-size: 22px;
        margin-bottom: 20px;
        border-bottom: 1px solid #333;
        padding-bottom: 10px;
        color: #ffcc70;
    }

    .song-item {
        list-style: none;
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .song-info {
        flex: 1;
    }

    .song-info h3 {
        margin: 0 0 5px;
        font-size: 16px;
    }

    .song-info a {
        color: #90caf9;
        text-decoration: none;
    }

    .song-info a:hover {
        text-decoration: underline;
    }

    .album-icon {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        margin-left: 10px;
    }

    .comment-section {
        margin-top: 50px;
        background-color: #1e1e2f;
        padding: 20px;
        border-radius: 12px;
    }

    .comment-section h2 {
        font-size: 22px;
        margin-bottom: 15px;
    }

    .comment-form textarea {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: none;
        resize: none;
        font-size: 16px;
    }

    .comment-form button {
        margin-top: 10px;
        padding: 10px 20px;
        background-color: #00b894;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
    }

    .comment-form button:hover {
        background-color: #019875;
    }

    .banner {
        background-color: #2f3640;
        color: #f1f1f1;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
    }
</style>

</head>
<body class="text-light">
<div class="container">
    @include('frontend.partials.sidebar')

     <main>
        <!-- Banner -->
        <div class="banner">Banner quảng cáo hoặc thông báo</div>

     





<div class="content-wrapper">
    <!-- Tin tức chính -->
    <div class="news-content">
        <h1 class="news-title">{{ $news->tieude }}</h1>
        <div class="news-unit">Đơn vị đăng: {{ $news->donvidang }}</div>
        <img src="{{ asset('storage/' . $news->hinhanh) }}" alt="Hình ảnh tin tức" class="news-image">
        <div class="news-body">{!! nl2br(e($news->noidung)) !!}</div>
        <a href="{{ route('frontend.news') }}" class="btn-back">← Quay lại danh sách tin tức</a>
    </div>

    <!-- Tin tức liên quan -->
    <div class="related-news">
        <h2>Tin tức xem thêm</h2>
        @foreach($relatedNews as $new)
            <li class="song-item">
                <div class="song-info">
                    <h3>
                        <a href="{{ route('frontend.news_show', ['id' => $new->id]) }}">
                            {{ $new->tieude }}
                        </a>
                    </h3>
                </div>
                <img src="{{ asset('storage/artists/' . $new->hinhanh) }}" alt="Hình ảnh" class="album-icon">
                
            </li>
        @endforeach
    </div>
</div>


        <!-- Bình luận -->
        <div class="comment-section">
            <h2>Bình luận</h2>
            <form action="#" method="POST" class="comment-form">
                <textarea name="comment" placeholder="Viết bình luận..." rows="4"></textarea>
                <button type="submit">Gửi bình luận</button>
            </form>
        </div>
    </main>
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>





