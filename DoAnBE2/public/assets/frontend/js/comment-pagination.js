document.addEventListener('DOMContentLoaded', function () {
    // Lấy container chứa danh sách bình luận
    const commentContainer = document.getElementById('comments-list-container');
    if (!commentContainer) return;

    // Lấy tất cả các dòng bình luận có class 'comment-item-js'
    const comments = Array.from(commentContainer.getElementsByClassName('comment-item-js'));

    // Lấy container chứa controls phân trang
    const paginationControls = document.getElementById('pagination-controls');
    if (!paginationControls) return;

    const itemsPerPage = 5;           // Số bình luận hiển thị trên mỗi trang
    const maxPageButtons = 5;         // Số nút phân trang tối đa hiển thị
    let currentPage = 1;              // Trang hiện tại
    const pageCount = Math.ceil(comments.length / itemsPerPage);

    // Hiển thị bình luận theo trang hiện tại
    function displayComments(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        comments.forEach((comment, index) => {
            comment.style.display = (index >= start && index < end) ? '' : 'none';
        });
    }

    // Tạo nút phân trang
    function createPaginationButton(text, pageNum, isActive = false, isDisabled = false) {
        const button = document.createElement('button');
        button.innerText = text;
        button.style.margin = '0 5px';
        button.classList.add('pagination-btn');

        if (isActive) button.style.fontWeight = 'bold';
        if (isDisabled) button.disabled = true;

        button.addEventListener('click', () => {
            if (!isDisabled) {
                currentPage = pageNum;
                displayComments(currentPage);
                setupPagination();
            }
        });

        return button;
    }

    // Thiết lập phân trang
    function setupPagination() {
        paginationControls.innerHTML = '';

        const prevButton = createPaginationButton('<', currentPage - 1, false, currentPage === 1);
        paginationControls.appendChild(prevButton);

        let startPage = Math.max(1, currentPage - Math.floor(maxPageButtons / 2));
        let endPage = Math.min(pageCount, startPage + maxPageButtons - 1);

        if (endPage - startPage + 1 < maxPageButtons) {
            startPage = Math.max(1, endPage - maxPageButtons + 1);
        }

        if (startPage > 1) {
            paginationControls.appendChild(createPaginationButton('1', 1, currentPage === 1));
            if (startPage > 2) {
                const ellipsis = document.createElement('span');
                ellipsis.innerText = '...';
                paginationControls.appendChild(ellipsis);
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            paginationControls.appendChild(createPaginationButton(i.toString(), i, currentPage === i));
        }

        if (endPage < pageCount) {
            if (endPage < pageCount - 1) {
                const ellipsis = document.createElement('span');
                ellipsis.innerText = '...';
                paginationControls.appendChild(ellipsis);
            }
            paginationControls.appendChild(createPaginationButton(pageCount.toString(), pageCount, currentPage === pageCount));
        }

        const nextButton = createPaginationButton('>', currentPage + 1, false, currentPage === pageCount);
        paginationControls.appendChild(nextButton);
    }

    // Khởi tạo nếu có bình luận
    if (comments.length > 0) {
        displayComments(currentPage);
        setupPagination();
    }
});