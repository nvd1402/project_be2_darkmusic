// assets/frontend/js/songs.js

// Lấy CSRF token một lần ở đầu file, nó sẽ được sử dụng cho tất cả các yêu cầu fetch
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.addEventListener('DOMContentLoaded', function() {
    // --- 1. Logic Phân trang Danh sách Bài hát (Không liên quan trực tiếp đến lỗi phát nhạc) ---
    const songsContainer = document.getElementById('songs-list-container');
    // Kiểm tra xem songsContainer có tồn tại không trước khi truy cập các thuộc tính của nó
    let songs = [];
    let paginationControls = null;
    let songsPerPage = 5;
    let maxPageButtons = 5;
    let currentPage = 1;
    let pageCount = 0;

    if (songsContainer) {
        songs = Array.from(songsContainer.getElementsByClassName('songs-item-js'));
        paginationControls = document.getElementById('pagination-controls');
        pageCount = Math.ceil(songs.length / songsPerPage);

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
            if (!paginationControls) return; // Đảm bảo paginationControls tồn tại
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
    }
    // --- KẾT THÚC LOGIC PHÂN TRANG ---

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
            const songId = this.dataset.songId || audioId.replace('audio-', ''); // Ưu tiên data-song-id, nếu không thì trích xuất từ audioId


            if (audio.paused) {
                // Tạm dừng tất cả các audio khác đang phát
                document.querySelectorAll('audio').forEach(a => {
                    if (!a.paused && a !== audio) { // Nếu đang phát và không phải audio hiện tại
                        a.pause();
                        const otherBtn = document.querySelector(`button[data-audio-id="${a.id}"]`);
                        if (otherBtn) {
                            const otherIcon = otherBtn.querySelector('i');
                            // SỬA: Đảm bảo sử dụng Boxicons class cho các nút khác
                            otherIcon.classList.remove('bx-pause-circle');
                            otherIcon.classList.add('bx-play-circle');
                        }
                    }
                });

                audio.play(); // Bắt đầu phát bài hát hiện tại
                // SỬA: Đảm bảo sử dụng Boxicons class cho nút hiện tại
                icon.classList.remove('bx-play-circle');
                icon.classList.add('bx-pause-circle');

                // --- Gửi sự kiện 'songPlayed' để kích hoạt tăng lượt xem ---
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
                // SỬA: Đảm bảo sử dụng Boxicons class
                icon.classList.remove('bx-pause-circle');
                icon.classList.add('bx-play-circle');
                // Không gửi sự kiện 'songPlayed' khi tạm dừng
            }
        });
    });

    // --- Logic hiển thị thời lượng và cập nhật thời gian bài hát ---
    document.querySelectorAll('audio').forEach(audio => {
        // Trong rankings.blade.php, .audio-duration nằm trực tiếp trong li.song-item, không phải trong .song-audio
        // Cần điều chỉnh cách tìm kiếm .audio-duration cho phù hợp với cả hai trang
        let durationDisplay = audio.closest('.song-item')?.querySelector('.audio-duration');
        // Nếu không tìm thấy trong .song-item (như trường hợp của all_songs.blade.php), thử tìm trong .song-audio
        if (!durationDisplay) {
            durationDisplay = audio.closest('.song-audio')?.querySelector('.audio-duration');
        }


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
        if (isNaN(seconds) || seconds < 0) {
            return '0:00'; // Xử lý trường hợp không hợp lệ
        }
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
    document.addEventListener('songPlayed', (event) => {
        const { songId, button } = event.detail;

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
                    // Cố gắng tìm kiếm lượt xem bằng data-song-id của viewElement
                    const viewElement = document.querySelector(`.views-count[data-song-id="${songId}"]`);
                    // Fallback nếu .views-count không phải là class duy nhất
                    if (!viewElement) {
                        const alternativeViewElement = document.querySelector(`.view-count[data-song-id="${songId}"]`);
                        if (alternativeViewElement) {
                            viewElement = alternativeViewElement;
                        }
                    }

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
