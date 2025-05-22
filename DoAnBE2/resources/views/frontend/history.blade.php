<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Nghe Nhạc</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/frontend/images/free.zing.mp3.vip.reference_1.png') }}" type="image/png" >
    {{-- Nếu bạn có một partial head chung, bạn có thể include nó ở đây --}}
    {{-- @include('frontend.partials.head') --}}

    <style>
        /* CSS cho trang lịch sử nghe nhạc */
        body {
            background-color: #1a1a2e; /* Màu nền tổng thể, phù hợp với giao diện của bạn */
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex; /* Dùng flexbox cho layout chính */
            min-height: 100vh; /* Chiều cao tối thiểu là 100% viewport */
        }

        .container {
            display: flex;
            width: 100%;
        }

        main {
            flex-grow: 1; /* Để phần main chiếm hết không gian còn lại */
            padding: 20px;
            overflow-y: auto; /* Cho phép cuộn nếu nội dung dài */
        }

        .history-container {
            max-width: 900px;
            margin: 20px auto; /* Tùy chỉnh margin để không bị dính sát lề */
            background-color: #2b2b36; /* Màu nền của khối lịch sử */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            color: #fff;
        }

        .history-container h1 {
            text-align: center;
            color: #7289DA; /* Màu tiêu đề */
            margin-bottom: 30px;
            font-size: 2.2em;
        }

        .history-list {
            list-style: none;
            padding: 0;
        }

        .history-list .history-item {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 10px;
            background-color: #36393f; /* Màu nền của mỗi item lịch sử */
            border-radius: 8px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .history-list .history-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .history-item .song-thumbnail img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
            flex-shrink: 0; /* Ngăn ảnh bị co lại */
        }

        .history-item .song-details {
            flex-grow: 1; /* Chiếm không gian còn lại */
        }

        .history-item .song-details .name {
            font-weight: bold;
            font-size: 1.1em;
            color: #fff;
            margin-bottom: 5px;
        }

        .history-item .song-details .artist-genre {
            font-size: 0.9em;
            color: #bbb;
        }

        .history-item .listened-at {
            font-size: 0.9em;
            color: #999;
            margin-left: 20px;
            text-align: right;
            flex-shrink: 0;
        }

        /* Phân trang */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .pagination .page-item {
            margin: 0 5px;
        }
        .pagination .page-link {
            display: block;
            padding: 8px 12px;
            border-radius: 5px;
            background-color: #36393f;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }
        .pagination .page-link:hover,
        .pagination .page-item.active .page-link {
            background-color: #7289DA;
            color: white;
        }

        /* Đảm bảo sidebar và right_content được include và có CSS phù hợp */
        /* Ví dụ nếu sidebar của bạn có width cố định */
        /* .sidebar { width: 250px; flex-shrink: 0; } */
        /* .right-content { width: 300px; flex-shrink: 0; } */
    </style>
</head>
<body>
<div class="container">
    {{-- Nếu bạn có sidebar, hãy bao gồm nó --}}
    {{-- @include('frontend.partials.sidebar') --}}

    <main>
        <div class="history-container">
            <h1>Lịch Sử Nghe Nhạc Của Bạn</h1>

            @if($listeningHistory->isEmpty())
                <p style="text-align: center; color: #bbb;">Bạn chưa nghe bài hát nào gần đây.</p>
            @else
                <div class="history-list">
                    @foreach($listeningHistory as $record)
                        <div class="history-item">
                            <div class="song-thumbnail">
                                @if($record->song && $record->song->anh_daidien)
                                    <img src="{{ asset('storage/' . $record->song->anh_daidien) }}" alt="{{ $record->song->tenbaihat }}">
                                @else
                                    <img src="{{ asset('assets/frontend/images/default_song_60x60.png') }}" alt="No Image">
                                @endif
                            </div>
                            <div class="song-details">
                                <div class="name">{{ $record->song->tenbaihat ?? 'Bài hát không xác định' }}</div>
                                <div class="artist-genre">
                                    {{ $record->song->artist->name_artist ?? 'Unknown Artist' }} -
                                    {{ $record->song->category->tentheloai ?? 'Unknown Genre' }}
                                </div>
                            </div>
                            <div class="listened-at">
                                {{ $record->listened_at->locale('vi')->diffForHumans() }}
                                <br>
                                <small>{{ $record->listened_at->format('H:i, d/m/Y') }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Links phân trang --}}
                <div class="pagination-wrapper">
                    {{ $listeningHistory->links() }}
                </div>
            @endif
        </div>
    </main>

    {{-- Nếu bạn có right content, hãy bao gồm nó --}}
    {{-- @include('frontend.partials.right_content') --}}
</div>

{{-- Script tags của bạn --}}
{{-- Đảm bảo các script này cũng được tải ở đây, hoặc trong file layout chính của bạn --}}
<script type='text/javascript' src="{{ asset('assets/frontend/js/script.js') }}"></script>
<script type='text/javascript' src="{{ asset('assets/frontend/js/audio-controls.js') }}"></script>
<script src="{{ asset('assets/frontend/js/handle-ad.js') }}"></script>
</body>
</html>
