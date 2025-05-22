<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="user-id" content="{{ Auth::user()->id }}" />

    <title>Lịch Sử Nghe Nhạc</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet' />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}" />
    <link rel="icon" href="{{ asset('assets/frontend/images/free.zing.mp3.vip.reference_1.png') }}" type="image/png" />

    <style>
        /* CSS như mình đã chỉnh sửa trước */
        body {
            background-color: #000000;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }
        .container {
            display: flex;
            width: 100%;
        }
        main {
            flex-grow: 1;
            padding: 20px 30px;
            overflow-y: auto;
            background-color: #000000;
            color: #e0e0e0;
        }
        .history-container {
            max-width: 900px;
            margin: 20px auto;
            background: linear-gradient(rgb(7, 7, 34), rgb(66, 66, 136));
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
            color: #f0f0f0;
        }
        .history-container h1 {
            color: #ffffff;
            margin-bottom: 25px;
            font-size: 2.4rem;
            font-weight: 700;
            padding-left: 10px;
            border-left: 5px solid #ff5a5f;
        }
        .history-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .history-list .history-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            margin-bottom: 12px;
            background: linear-gradient(rgb(7, 7, 34), rgb(13, 13, 27));
            border-radius: 10px;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
        }
        .history-list .history-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }
        .history-item .song-thumbnail img {
            width: 65px;
            height: 65px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 20px;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }
        .history-item .song-details {
            flex-grow: 1;
            min-width: 0;
        }
        .history-item .song-details .name {
            font-weight: 700;
            font-size: 1.2rem;
            color: #fff;
            margin-bottom: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .history-item .song-details .artist-genre {
            font-size: 0.9rem;
            color: #b0b8d1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .history-item .actions {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-left: 20px;
            flex-shrink: 0;
        }
        .history-item .actions .icon-btn {
            background: none;
            border: none;
            font-size: 1.6rem;
            cursor: pointer;
            color: #d0d8f9;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .history-item .actions .icon-btn:hover {
            color: #ff5a5f;
        }
        .clear-history-wrapper {
            text-align: right;
            margin-top: 30px;
            padding-right: 10px;
        }
        .clear-history-btn {
            background-color: #ff5a5f;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.3s ease;
        }
        .clear-history-btn i {
            font-size: 1.3rem;
        }
        .clear-history-btn:hover {
            background-color: #e04e54;
        }
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .pagination .page-item {
            margin: 0 6px;
        }
        .pagination .page-link {
            display: block;
            padding: 10px 14px;
            border-radius: 6px;
            background-color: #2a368f;
            color: #ddd;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .pagination .page-link:hover {
            background-color: #ff5a5f;
            color: #fff;
        }
        .pagination .page-item.active .page-link {
            background-color: #ff5a5f;
            color: white;
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
                <input type="text" placeholder="type here to search" />
            </div>
        </header>

        <div class="history-container">
            <h1>Lịch sử nghe nhạc</h1>

            @if($listeningHistory->isEmpty())
                <p style="text-align: center; color: #ffffff;">Bạn chưa nghe bài hát nào gần đây.</p>
            @else
                <div class="history-list">
                    @foreach($listeningHistory as $record)
                        <div class="history-item">
                            <div class="song-thumbnail">
                                @if($record->song && $record->song->anh_daidien)
                                    <img src="{{ asset('storage/' . $record->song->anh_daidien) }}" alt="{{ $record->song->tenbaihat }}" />
                                @else
                                    <img src="{{ asset('assets/frontend/images/default_song_60x60.png') }}" alt="No Image" />
                                @endif
                            </div>
                            <div class="song-details">
                                <div class="name">{{ $record->song->tenbaihat ?? 'Bài hát không xác định' }}</div>
                                <div class="artist-genre">
                                    {{ $record->song->artist->name_artist ?? 'Unknown Artist' }} -
                                    {{ $record->song->category->tentheloai ?? 'Unknown Genre' }}
                                </div>
                            </div>
                            <div class="actions">
                                <audio id="audio-{{ $record->song->id }}" src="{{ asset('storage/' . $record->song->file_amthanh) }}"></audio>
                                <button class="icon-btn play-pause-button" data-audio-id="audio-{{ $record->song->id }}">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button class="icon-btn delete-btn" data-history-id="{{ $record->id }}">
                                    <i class="bx bx-x"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="clear-history-wrapper">
                <button id="clearAllHistory" class="clear-history-btn">
                    <i class="bx bx-trash"></i> Xóa tất cả lịch sử
                </button>
            </div>
        </div>
    </main>

    {{-- Nếu bạn có right content, hãy bao gồm nó --}}
    {{-- @include('frontend.partials.right_content') --}}
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Play/Pause audio
    document.querySelectorAll('.play-pause-button').forEach(button => {
        button.addEventListener('click', function () {
            const audioId = this.dataset.audioId;
            const audio = document.getElementById(audioId);
            if (!audio) {
                console.error(`Không tìm thấy audio với id ${audioId}`);
                return;
            }

            const icon = this.querySelector('i');

            if (audio.paused) {
                // Pause tất cả audio khác trước khi play audio này
                document.querySelectorAll('audio').forEach(a => {
                    if (!a.paused) {
                        a.pause();
                        const btn = document.querySelector(`button[data-audio-id="${a.id}"]`);
                        if (btn) {
                            btn.querySelector('i').classList.remove('fa-pause');
                            btn.querySelector('i').classList.add('fa-play');
                        }
                    }
                });

                audio.play();
                icon.classList.remove('fa-play');
                icon.classList.add('fa-pause');

                // Gọi API lưu lịch sử nghe
                const songId = audioId.replace('audio-', '');
                fetch('/listening-history/save', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ song_id: songId }),
                })
                    .then(res => {
                        if (res.ok) {
                            console.log('Lưu lịch sử nghe thành công');
                        } else {
                            console.warn('Lưu lịch sử nghe thất bại');
                        }
                    })
                    .catch(() => console.warn('Lỗi kết nối khi lưu lịch sử nghe'));

            } else {
                audio.pause();
                icon.classList.remove('fa-pause');
                icon.classList.add('fa-play');
            }
        });
    });

    // Xóa 1 bản ghi lịch sử
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const historyId = this.dataset.historyId;
            if (!confirm('Bạn có chắc muốn xóa bản ghi này không?')) return;

            fetch(`/listening-history/${historyId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.history-item').remove();
                    } else {
                        alert(data.message || 'Xóa thất bại');
                    }
                })
                .catch(() => alert('Lỗi kết nối, vui lòng thử lại.'));
        });
    });

    // Xóa tất cả lịch sử
    document.getElementById('clearAllHistory').addEventListener('click', function () {
        if (!confirm('Bạn có chắc muốn xóa tất cả lịch sử nghe không?')) return;

        fetch('/listening-history/clear-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const historyList = document.querySelector('.history-list');
                    if (historyList) {
                        historyList.innerHTML = '<p style="text-align: center; color: #fff;">Bạn chưa nghe bài hát nào gần đây.</p>';
                    }
                } else {
                    alert('Xóa thất bại, vui lòng thử lại.');
                }
            })
            .catch(() => alert('Lỗi kết nối, vui lòng thử lại.'));
    });
</script>

</body>
</html>
