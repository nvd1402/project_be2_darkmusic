<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Nghe Nhạc</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/frontend/images/free.zing.mp3.vip.reference_1.png') }}" type="image/png" >

    {{-- Nếu bạn có một partial head chung và muốn nó ở đây, hãy bỏ comment --}}
    {{-- @include('frontend.partials.head') --}}

    <style>
        /* CSS cho trang lịch sử nghe nhạc */
        body {
            background-color: #1a1a2e; /* Màu nền tổng thể, phù hợp với giao diện của bạn */
            color: #ffffff;
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
            background-color: #000000; /* Nền của phần main để giống ảnh bạn gửi */
            color: #333; /* Màu chữ cho phần chính */
        }

        .history-container {
            max-width: 900px;
            margin: 20px auto; /* Tùy chỉnh margin để không bị dính sát lề */
            background-color: #1484fc; /* Màu nền của khối lịch sử */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Bóng nhẹ */
            color: #333;
        }

        .history-container h1 {
            text-align: left; /* Căn trái tiêu đề */
            color: #ffffff; /* Màu tiêu đề */
            margin-bottom: 30px;
            font-size: 2.2em;
            padding-left: 15px; /* Giảm padding để sát lề hơn */
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
            background-color: #fff; /* Màu nền của mỗi item lịch sử */
            border: 1px solid #eee; /* Viền nhẹ */
            border-radius: 8px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .history-list .history-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
            color: #333;
            margin-bottom: 5px;
        }

        .history-item .song-details .artist-genre {
            font-size: 0.9em;
            color: #666;
        }

        .history-item .actions {
            display: flex;
            align-items: center;
            margin-left: 20px;
            flex-shrink: 0;
        }

        .history-item .actions .icon-btn {
            background: none;
            border: none;
            font-size: 1.5em; /* Kích thước icon */
            margin-left: 10px;
            cursor: pointer;
            color: #555;
            transition: color 0.2s ease;
        }

        .history-item .actions .icon-btn:hover {
            color: #7289DA; /* Màu khi hover */
        }

        /* Nút xóa tất cả */
        .clear-history-wrapper {
            text-align: right;
            margin-top: 20px;
            padding-right: 15px; /* Để khớp với padding của tiêu đề */
        }

        .clear-history-btn {
            background-color: #f44336; /* Màu đỏ */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            display: inline-flex; /* Để icon và text trên cùng 1 dòng */
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .clear-history-btn i {
            margin-right: 8px; /* Khoảng cách giữa icon và text */
        }

        .clear-history-btn:hover {
            background-color: #d32f2f;
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
            background-color: #eee;
            color: #333;
            text-decoration: none;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .pagination .page-link:hover,
        .pagination .page-item.active .page-link {
            background-color: #7289DA;
            color: white;
        }

        /* Đảm bảo sidebar và right_content được include và có CSS phù hợp */
        /* .sidebar { width: 250px; flex-shrink: 0; } */
        /* .right-content { width: 300px; flex-shrink: 0; } */
    </style>
</head>
<body>
<div class="container">
    {{-- Nếu bạn có sidebar, hãy bao gồm nó --}}
    @include('frontend.partials.sidebar') {{-- --}}

    <main>
        {{-- Header của trang (search bar, menu button) --}}
        <header>
            <div class="nav-links">
                <button class="menu-btn" id="menu-open">
                    <i class='bx bx-menu'></i>
                </button>
            </div>

            <div class="search">
                <i class='bx bx-search-alt-2'></i>
                <input type="text" placeholder="type here to search">
            </div>
        </header>

        <div class="history-container">
            <h1>Lịch sử nghe nhạc</h1> {{-- --}}

            @if($listeningHistory->isEmpty())
                <p style="text-align: center; color: #ffffff;">Bạn chưa nghe bài hát nào gần đây.</p>
            @else
                <div class="history-list">
                    @foreach($listeningHistory as $record)
                        <div class="history-item">
                            <div class="song-thumbnail">
                                @if($record->song && $record->song->thumbnail) {{-- --}}
                                <img src="{{ asset('storage/' . $record->song->thumbnail) }}" alt="{{ $record->song->title }}"> {{-- --}}
                                @else
                                    <img src="{{ asset('assets/frontend/images/default_song_60x60.png') }}" alt="No Image">
                                @endif
                            </div>
                            <div class="song-details">
                                <div class="name">{{ $record->song->title ?? 'Bài hát không xác định' }}</div> {{-- --}}
                                <div class="artist-genre">
                                    {{ $record->song->artist->name_artist ?? 'Unknown Artist' }} - {{-- --}}
                                    {{ $record->song->category->tentheloai ?? 'Unknown Genre' }} {{-- --}}
                                </div>
                            </div>
                            <div class="actions">
                                <button class="icon-btn play-btn" data-song-id="{{ $record->song->id }}">
                                    <i class='bx bx-play'></i>
                                </button>
                                <button class="icon-btn delete-btn" data-history-id="{{ $record->id }}">
                                    <i class='bx bx-x'></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Nút xóa tất cả --}}
                <div class="clear-history-wrapper">
                    <button class="clear-history-btn" id="clearAllHistory">
                        <i class='bx bx-trash'></i> Xóa tất cả
                    </button>
                </div>

                {{-- Links phân trang --}}
                <div class="pagination-wrapper">
                    {{ $listeningHistory->links() }}
                </div>
            @endif
        </div>
    </main>

    {{-- Nếu bạn có right content, hãy bao gồm nó --}}
    @include('frontend.partials.right_content') {{-- --}}
</div>

{{-- Script tags của bạn --}}
{{-- Đảm bảo các script này cũng được tải ở đây, hoặc trong file layout chính của bạn --}}
<script type='text/javascript' src="{{ asset('assets/frontend/js/script.js') }}"></script>
<script type='text/javascript' src="{{ asset('assets/frontend/js/audio-controls.js') }}"></script>
<script src="{{ asset('assets/frontend/js/handle-ad.js') }}"></script>
<script type='text/javascript' src="{{ asset('assets/frontend/js/songs.js') }}"></script>


<script>
    // === JavaScript cho các nút hành động ===
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý nút Play
        document.querySelectorAll('.play-btn').forEach(button => {
            button.addEventListener('click', function() {
                const songId = this.dataset.songId;
                alert('Phát bài hát có ID: ' + songId);
                // Thực hiện logic phát nhạc ở đây (ví dụ: gửi request AJAX tới API phát nhạc)
            });
        });

        // Xử lý nút Delete (xóa từng bản ghi lịch sử)
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const historyId = this.dataset.historyId;
                if (confirm('Bạn có chắc muốn xóa bản ghi lịch sử này không?')) {
                    // Thực hiện logic xóa bản ghi lịch sử (ví dụ: gửi request AJAX tới route xóa)
                    // Ví dụ: fetch('/history/' + historyId, { method: 'DELETE' })
                    // .then(response => response.json())
                    // .then(data => {
                    //     if (data.success) {
                    //         this.closest('.history-item').remove(); // Xóa item khỏi DOM
                    //     } else {
                    //         alert('Không thể xóa bản ghi: ' + data.message);
                    //     }
                    // });
                    alert('Xóa bản ghi lịch sử có ID: ' + historyId);
                    // Sau khi xóa thành công, bạn có thể xóa item khỏi DOM hoặc reload trang
                    this.closest('.history-item').remove(); // Xóa tạm thời khỏi giao diện
                }
            });
        });

        // Xử lý nút Xóa tất cả lịch sử
        const clearAllHistoryBtn = document.getElementById('clearAllHistory');
        if (clearAllHistoryBtn) {
            clearAllHistoryBtn.addEventListener('click', function() {
                if (confirm('Bạn có chắc chắn muốn xóa TẤT CẢ lịch sử nghe nhạc không?')) {
                    // Thực hiện logic xóa tất cả lịch sử (ví dụ: gửi request AJAX tới route xóa tất cả)
                    // Ví dụ: fetch('/history/clear-all', { method: 'POST' })
                    // .then(response => response.json())
                    // .then(data => {
                    //     if (data.success) {
                    //         document.querySelector('.history-list').innerHTML = '<p style="text-align: center; color: #666;">Bạn chưa nghe bài hát nào gần đây.</p>';
                    //         this.remove(); // Xóa nút "Xóa tất cả"
                    //     } else {
                    //         alert('Không thể xóa tất cả lịch sử: ' + data.message);
                    //     }
                    // });
                    alert('Đã yêu cầu xóa tất cả lịch sử.');
                    // Sau khi xóa thành công, bạn có thể cập nhật DOM
                    document.querySelector('.history-list').innerHTML = '<p style="text-align: center; color: #666;">Bạn chưa nghe bài hát nào gần đây.</p>';
                    this.remove(); // Xóa nút "Xóa tất cả"
                }
            });
        }
    });
</script>

</body>
</html>
