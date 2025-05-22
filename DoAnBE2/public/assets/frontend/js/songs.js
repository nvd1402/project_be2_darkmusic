
    document.addEventListener('DOMContentLoaded', function() {
    const songsContainer = document.getElementById('songs-list-container');
    // Vẫn chọn songs-item-js, nhưng giờ nó là div thay vì ul
    const songs = Array.from(songsContainer.getElementsByClassName('songs-item-js'));
    const paginationControls = document.getElementById('pagination-controls');
    const songsPerPage = 5; // You can change this number
    const maxPageButtons = 5; // How many numbered buttons to show (e.g., 1 2 3 ... 10)
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
    setupPagination(); // Re-render pagination buttons
}
});
    return button;
}

    function setupPagination() {
    paginationControls.innerHTML = ''; // Clear previous buttons

    // Previous button
    const prevButton = createPaginationButton('<', currentPage - 1, false, currentPage === 1);
    paginationControls.appendChild(prevButton);

    // Determine the range of page numbers to display
    let startPage = Math.max(1, currentPage - Math.floor(maxPageButtons / 2));
    let endPage = Math.min(pageCount, startPage + maxPageButtons - 1);

    if (endPage - startPage + 1 < maxPageButtons) {
    startPage = Math.max(1, endPage - maxPageButtons + 1);
}

    // Always show the first page if not in the range
    if (startPage > 1) {
    paginationControls.appendChild(createPaginationButton('1', 1, currentPage === 1));
    if (startPage > 2) { // Add ellipsis if there's a gap
    const ellipsis = document.createElement('span');
    ellipsis.innerText = '...';
    paginationControls.appendChild(ellipsis);
}
}

    // Numbered page buttons
    for (let i = startPage; i <= endPage; i++) {
    paginationControls.appendChild(createPaginationButton(i.toString(), i, currentPage === i));
}

    // Always show the last page if not in the range
    if (endPage < pageCount) {
    if (endPage < pageCount - 1) { // Add ellipsis if there's a gap
    const ellipsis = document.createElement('span');
    ellipsis.innerText = '...';
    paginationControls.appendChild(ellipsis);
}
    paginationControls.appendChild(createPaginationButton(pageCount.toString(), pageCount, currentPage === pageCount));
}

    // Next button
    const nextButton = createPaginationButton('>', currentPage + 1, false, currentPage === pageCount);
    paginationControls.appendChild(nextButton);
}

    // Initial setup
    setupPagination();
    displaySongs(currentPage);
});


//am thanh thanh
    document.addEventListener('DOMContentLoaded', function() {
        const playPauseButtons = document.querySelectorAll('.play-pause-button');

        playPauseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const audioId = this.dataset.audioId;
                const audio = document.getElementById(audioId);
                const durationDisplay = this.nextElementSibling; // Lấy phần tử kế tiếp (span.audio-duration)

                if (audio.paused) {
                    audio.play();
                    this.classList.add('playing'); // Thêm class 'playing' để thay đổi icon
                    this.querySelector('i').classList.remove('fa-play');
                    this.querySelector('i').classList.add('fa-pause');
                } else {
                    audio.pause();
                    this.classList.remove('playing');
                    this.querySelector('i').classList.remove('fa-pause');
                    this.querySelector('i').classList.add('fa-play');
                }
            });
        });

        // Hiển thị thời lượng
        document.querySelectorAll('audio').forEach(audio => {
            const durationDisplay = audio.nextElementSibling.querySelector('.audio-duration');
            audio.addEventListener('loadedmetadata', function() {
                const totalDuration = formatTime(audio.duration);
                durationDisplay.textContent = `0:00 / ${totalDuration}`;
            });

            audio.addEventListener('timeupdate', function() {
                const currentTime = formatTime(audio.currentTime);
                const totalDuration = formatTime(audio.duration);
                durationDisplay.textContent = `${currentTime} / ${totalDuration}`;
            });
        });

        // Hàm định dạng thời gian (ví dụ: 120 giây thành 2:00)
        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = Math.floor(seconds % 60);
            const formattedSeconds = remainingSeconds < 10 ? '0' + remainingSeconds : remainingSeconds;
            return minutes + ':' + formattedSeconds;
        }
    });
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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ action })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not OK');
                    }
                    return response.json();
                })
                .then(data => {
                    // Toggle icon
                    this.textContent = isLiked ? '♡' : '♥';
                    this.style.color = isLiked ? 'gray' : 'gray';

                    // Hiệu ứng trái tim bay
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
                    alert('Lỗi kết nối hoặc xử lý. Vui lòng thử lại.');
                    console.error('Fetch error:', error);
                });
        });
    });






