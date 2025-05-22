document.addEventListener('DOMContentLoaded', function () {
    const albumContainer = document.getElementById('album-list-container');
    if (!albumContainer) return;

    const albums = Array.from(albumContainer.getElementsByClassName('album-item-js'));
    const paginationControls = document.getElementById('pagination-controls');
    if (!paginationControls) return;

    const itemsPerPage = 5;
    const maxPageButtons = 5;
    let currentPage = 1;
    const pageCount = Math.ceil(albums.length / itemsPerPage);

    function displayAlbums(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        albums.forEach((album, index) => {
            album.style.display = (index >= start && index < end) ? '' : 'none';
        });
    }

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
                displayAlbums(currentPage);
                setupPagination();
            }
        });

        return button;
    }

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

    if (albums.length > 0) {
        displayAlbums(currentPage);
        setupPagination();
    }
});
