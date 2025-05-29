document.addEventListener('DOMContentLoaded', function () {
    const commentContainer = document.getElementById('comments-list-container');
    if (!commentContainer) return;

    const comments = Array.from(commentContainer.getElementsByClassName('comment-item-js'));
    const paginationControls = document.getElementById('pagination-controls');
    if (!paginationControls) return;

    const itemsPerPage = 5;
    const maxPageButtons = 5;
    let currentPage = 1;
    const totalPages = Math.ceil(comments.length / itemsPerPage);

    function showComments(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        comments.forEach((comment, index) => {
            comment.style.display = (index >= start && index < end) ? '' : 'none';
        });
    }

    function createButton(label, targetPage, isActive = false, isDisabled = false) {
        const btn = document.createElement('button');
        btn.innerText = label;
        btn.classList.add('pagination-btn');
        btn.style.margin = '0 5px';
        btn.disabled = isDisabled;

        if (isActive) {
            btn.style.fontWeight = 'bold';
            btn.style.textDecoration = 'underline';
        }

        btn.addEventListener('click', () => {
            if (!isDisabled) {
                currentPage = targetPage;
                showComments(currentPage);
                renderPagination();
            }
        });

        return btn;
    }

    function renderPagination() {
        paginationControls.innerHTML = '';

        // Previous Button
        paginationControls.appendChild(
            createButton('<', currentPage - 1, false, currentPage === 1)
        );

        // Page number buttons with ellipsis if needed
        let startPage = Math.max(1, currentPage - Math.floor(maxPageButtons / 2));
        let endPage = Math.min(totalPages, startPage + maxPageButtons - 1);

        if (endPage - startPage + 1 < maxPageButtons) {
            startPage = Math.max(1, endPage - maxPageButtons + 1);
        }

        if (startPage > 1) {
            paginationControls.appendChild(createButton('1', 1, currentPage === 1));
            if (startPage > 2) {
                paginationControls.appendChild(createEllipsis());
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            paginationControls.appendChild(createButton(i, i, currentPage === i));
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationControls.appendChild(createEllipsis());
            }
            paginationControls.appendChild(createButton(totalPages, totalPages, currentPage === totalPages));
        }

        // Next Button
        paginationControls.appendChild(
            createButton('>', currentPage + 1, false, currentPage === totalPages)
        );
    }

    function createEllipsis() {
        const span = document.createElement('span');
        span.innerText = '...';
        span.style.margin = '0 5px';
        return span;
    }

    if (comments.length > 0) {
        showComments(currentPage);
        renderPagination();
    }
});
