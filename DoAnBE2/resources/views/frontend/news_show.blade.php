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
        .news-content, .related-news, .comment-section {
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }
        .news-content {
            flex: 3;
            background-color: #1e1e2f;
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
        }
        .related-news {
            flex: 1.2;
            background-color: #1a1a2a;
            max-height: 600px;
            overflow-y: auto;
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
        .song-info a {
            color: #fff;
            text-decoration: none;
        }
        .album-icon {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            margin-left: 10px;
        }
        .comment-section {
            background-color: #1e1e2f;
            color: #ddd;
        }
        .comment-form textarea {
            width: 100%;
            background-color: #121212;
            color: #eee;
            border: 1px solid #444;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
        }
        .comment-form button {
            margin-top: 12px;
            background-color: #00b894;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 700;
            cursor: pointer;
        }
        .comment-list {
            margin-top: 30px;
        }
        .comment-item {
            background-color: #292946;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
            color: #bbb;
        }
        .comment-item p {
            margin: 0;
            font-size: 16px;
            color: #ddd;
        }
    </style>
</head>
<body class="text-light">
<div class="container">
    @include('frontend.partials.sidebar')
    <main>
        <div class="banner">
            @if ($bannerAd)
                <a href="{{ $bannerAd->link_url }}" target="_blank">
                    <img src="{{ asset('storage/' . $bannerAd->media_type) }}" alt="{{ $bannerAd->name }}">
                    <p>{{ $bannerAd->description }}</p>
                </a>
            @endif
        </div>

        <div class="content-wrapper">
            <div class="news-content">
                <h1 class="news-title">{{ $news->tieude }}</h1>
                <div class="news-unit">Đơn vị đăng: {{ $news->donvidang }}</div>
                <img src="{{ asset('storage/artists/' . $news->hinhanh) }}" alt="Hình ảnh tin tức" class="news-image">
                <div class="news-body">{!! nl2br(e($news->noidung)) !!}</div>
                <a href="{{ route('frontend.news') }}" class="btn-back">← Quay lại danh sách tin tức</a>
            </div>

            <div class="related-news">
                <h2>Tin tức xem thêm</h2>
                @foreach($relatedNews as $new)
                    <li class="song-item">
                        <div class="song-info">
                            <a href="{{ route('frontend.news_show', ['id' => $new->id]) }}">
                                {{ $new->tieude }}
                            </a>
                        </div>
                        <img src="{{ asset('storage/news_images/' . $new->hinhanh) }}" class="album-icon">
                    </li>
                @endforeach
            </div>
        </div>

        <hr>

        <div class="comment-section">
            <h2>Bình luận</h2>

            @auth
            <form id="commentForm" action="{{ route('frontend.comment.store', $news->id) }}" method="POST" class="comment-form">
                @csrf
                <textarea name="noidung" id="noidung" rows="4" placeholder="Nội dung bình luận..." required></textarea>
                <button type="submit">Gửi bình luận</button>
            </form>

            <div class="comment-list" id="commentList">
                @foreach($news->comments()->latest()->get() as $comment)
                    <div class="comment-item">
                        <div class="comment-header">
                            <strong>{{ $comment->user ? $comment->user->username : 'Khách' }}</strong>
                            <small>{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <p>{{ $comment->noidung }}</p>
                    </div>
                @endforeach
            </div>
            @else
                <p><a href="{{ route('login') }}">Đăng nhập</a> để bình luận.</p>
            @endauth
        </div>
    </main>
</div>

<script>
document.getElementById('commentForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const commentList = document.getElementById('commentList');
        const div = document.createElement('div');
        div.classList.add('comment-item');
        div.innerHTML = `
            <div class="comment-header">
                <strong>${data.username ?? 'Khách'}</strong>
                <small>${data.time}</small>
            </div>
            <p>${data.noidung}</p>
        `;
        commentList.prepend(div);
        form.reset();
    })
    .catch(error => alert('Đã có lỗi xảy ra!'));
});
</script>
</body>
</html>
