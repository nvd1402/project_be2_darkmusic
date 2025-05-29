// assets/frontend/js/songs.js

// Lấy CSRF token một lần ở đầu file, nó sẽ được sử dụng cho tất cả các yêu cầu fetch
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.addEventListener('DOMContentLoaded', function() {
    // --- 1. Logic Phân trang Danh sách Bài hát ---
    const songsContainer = document.getElementById('songs-list-container');
    const songs = Array.from(songsContainer.getElementsByClassName('songs-item-js'));
    const paginationControls = document.getElementById('pagination-controls');
    const songsPerPage = 5; // Số bài hát mỗi trang
    const maxPageButtons = 5; // Số nút số trang tối đa hiển thị
    let currentPage = 1;
    const pageCount = Math.ceil(songs.length / songsPerPage);

    function displaySongs(page) {
        const start = (page - 1) * songsPerPage;
        const end = start + songsPerPage;

        songs.forEach((song, index) => {
            if (index >= start && index < end) {
                song.classList.remove('hidden-song');
            } else {
                song.classList.add('hidden-song');
            }
        });
    }

    function createPaginationButton(text, pageNum, isActive = false, isDisabled = false) {
        const button = document.createElement('button');
        button.innerText = text;
        if (isActive) {
            button.classList.add('active');
        }
        if (isDisabled) {
            button.disabled = true;
        }
        button.addEventListener('click', () => {
            if (!isDisabled) {
                currentPage = pageNum;
                displaySongs(currentPage);
                setupPagination(); // Render lại các nút phân trang
            }
        });
        return button;
    }

    function setupPagination() {
        paginationControls.innerHTML = ''; // Xóa các nút cũ

        // Nút 'Previous'
        const prevButton = createPaginationButton('<', currentPage - 1, false, currentPage === 1);
        paginationControls.appendChild(prevButton);

        // Xác định phạm vi các số trang để hiển thị
        let startPage = Math.max(1, currentPage - Math.floor(maxPageButtons / 2));
        let endPage = Math.min(pageCount, startPage + maxPageButtons - 1);

        if (endPage - startPage + 1 < maxPageButtons) {
            startPage = Math.max(1, endPage - maxPageButtons + 1);
        }

        // Luôn hiển thị trang đầu tiên nếu không nằm trong phạm vi
        if (startPage > 1) {
            paginationControls.appendChild(createPaginationButton('1', 1, currentPage === 1));
            if (startPage > 2) { // Thêm dấu ... nếu có khoảng trống
                const ellipsis = document.createElement('span');
                ellipsis.innerText = '...';
                paginationControls.appendChild(ellipsis);
            }
        }

        // Các nút số trang
        for (let i = startPage; i <= endPage; i++) {
            paginationControls.appendChild(createPaginationButton(i.toString(), i, currentPage === i));
        }

        // Luôn hiển thị trang cuối cùng nếu không nằm trong phạm vi
        if (endPage < pageCount) {
            if (endPage < pageCount - 1) { // Thêm dấu ... nếu có khoảng trống
                const ellipsis = document.createElement('span');
                ellipsis.innerText = '...';
                paginationControls.appendChild(ellipsis);
            }
            paginationControls.appendChild(createPaginationButton(pageCount.toString(), pageCount, currentPage === pageCount));
        }

        // Nút 'Next'
        const nextButton = createPaginationButton('>', currentPage + 1, false, currentPage === pageCount);
        paginationControls.appendChild(nextButton);
    }

    // Thiết lập phân trang và hiển thị bài hát ban đầu
    setupPagination();
    displaySongs(currentPage);

    // --- 2. Logic Phát/Dừng Nhạc, Thời lượng và Lưu Lịch sử Nghe/Tăng Lượt Xem ---
    document.querySelectorAll('.play-pause-button').forEach(button => {
        button.addEventListener('click', function() {
            const audioId = this.dataset.audioId;
            const audio = document.getElementById(audioId);

            if (!audio) {
                console.error(`Không tìm thấy phần tử audio với id: ${audioId}`);
                return;
            }

            const icon = this.querySelector('i');
            const songId = audioId.replace('audio-', ''); // Trích xuất ID bài hát từ ID audio

            if (audio.paused) {
                // Tạm dừng tất cả các audio khác đang phát
                document.querySelectorAll('audio').forEach(a => {
                    if (!a.paused && a !== audio) { // Nếu đang phát và không phải audio hiện tại
                        a.pause();
                        const btn = document.querySelector(`button[data-audio-id="${a.id}"]`);
                        if (btn) {
                            btn.querySelector('i').classList.remove('fa-pause');
                            btn.querySelector('i').classList.add('fa-play');
                        }
                    }
                });

                audio.play(); // Bắt đầu phát bài hát hiện tại
                icon.classList.remove('fa-play');
                icon.classList.add('fa-pause');

                // --- Gửi sự kiện 'songPlayed' để kích hoạt tăng lượt xem ---
                // (Phần này sẽ được lắng nghe bởi chính file này ở khối code bên dưới)
                console.log(`[songs.js] Phát nhạc và gửi sự kiện 'songPlayed' cho Song ID: ${songId}`);
                const songPlayedEvent = new CustomEvent('songPlayed', {
                    detail: {
                        songId: songId,
                        button: this // Truyền nút để xử lý data-viewed
                    }
                });
                document.dispatchEvent(songPlayedEvent);

                // --- Gọi API lưu lịch sử nghe ---
                fetch('/listening-history/save', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin', // Đảm bảo gửi cookie (ví dụ: phiên)
                    body: JSON.stringify({ song_id: songId }),
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            console.warn('Lưu lịch sử nghe thất bại:', errorData);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        console.log('Lịch sử nghe đã lưu thành công');
                    } else {
                        console.warn('Lưu lịch sử nghe thất bại: Phản hồi không thành công', data);
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi gửi yêu cầu lưu lịch sử nghe:', error);
                });

            } else {
                // Tạm dừng bài hát
                audio.pause();
                icon.classList.remove('fa-pause');
                icon.classList.add('fa-play');
                // Không gửi sự kiện 'songPlayed' khi tạm dừng
            }
        });
    });

    // --- Logic hiển thị thời lượng và cập nhật thời gian bài hát ---
    document.querySelectorAll('audio').forEach(audio => {
        const durationDisplay = audio.closest('.song-audio')?.querySelector('.audio-duration');

        if (durationDisplay) {
            audio.addEventListener('loadedmetadata', function() {
                const totalDuration = formatTime(audio.duration);
                durationDisplay.textContent = `0:00 / ${totalDuration}`;
            });

            audio.addEventListener('timeupdate', function() {
                const currentTime = formatTime(audio.currentTime);
                const totalDuration = formatTime(audio.duration);
                durationDisplay.textContent = `${currentTime} / ${totalDuration}`;
            });
        } else {
            console.warn('Không tìm thấy phần tử .audio-duration cho audio:', audio.id);
        }
    });

    // Hàm định dạng thời gian (ví dụ: 120 giây thành 2:00)
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = Math.floor(seconds % 60);
        const formattedSeconds = remainingSeconds < 10 ? '0' + remainingSeconds : remainingSeconds;
        return minutes + ':' + formattedSeconds;
    }

    // --- 3. Logic Nút Like ---
    document.querySelectorAll('.btn-like').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const songId = this.dataset.songId;
            const isLiked = this.textContent.trim() === '♥';
            const action = isLiked ? 'unlike' : 'like';

            fetch(`/song/${songId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
                body: JSON.stringify({ action })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Lỗi mạng hoặc server không phản hồi OK');
                }
                return response.json();
            })
            .then(data => {
                this.textContent = isLiked ? '♡' : '♥';
                this.style.color = 'gray';

                if (!isLiked) {
                    const heart = document.createElement('span');
                    heart.textContent = '❤';
                    heart.classList.add('heart-float');
                    this.appendChild(heart);

                    setTimeout(() => {
                        heart.remove();
                    }, 1000);
                }
            })
            .catch(error => {
                alert('Có lỗi xảy ra khi xử lý lượt thích. Vui lòng thử lại.');
                console.error('Lỗi fetch like:', error);
            });
        });
    });

    // --- 4. Logic Tăng Lượt Xem (Đã di chuyển từ songs_view.js) ---
    // Lắng nghe sự kiện 'songPlayed' được gửi từ chính file này (hoặc bất kỳ nơi nào khác)
    document.addEventListener('songPlayed', (event) => {
        const { songId, button } = event.detail;

        // Chỉ gửi yêu cầu nếu chưa gửi trước đó cho nút này
        if (button.dataset.viewed === 'true') {
            console.log(`[songs.js - View Logic] Song ID ${songId} đã được xem từ nút này. Bỏ qua.`);
            return;
        }

        console.log(`[songs.js - View Logic] Đang gửi yêu cầu tăng lượt xem cho Song ID: ${songId}`);
        fetch(`/song/${songId}/view`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const viewElement = document.querySelector(`.view-count[data-song-id="${songId}"]`);
                    if (viewElement) {
                        viewElement.textContent = `Lượt xem: ${data.views}`;
                        console.log(`[songs.js - View Logic] Cập nhật lượt xem UI cho Song ID ${songId}: ${data.views}`);
                    }
                    button.dataset.viewed = 'true'; // Đánh dấu nút là đã xử lý lượt xem
                } else {
                    console.warn(`[songs.js - View Logic] Cập nhật lượt xem thất bại cho Song ID ${songId}:`, data);
                }
            })
            .catch(error => {
                console.error(`[songs.js - View Logic] Lỗi fetch view cho Song ID ${songId}:`, error);
            });
    });

}); // Kết thúc DOMContentLoaded cho toàn bộ file songs.js