document.addEventListener("DOMContentLoaded", function () {
    const tableContainer = document.getElementById("song-table-container");
    const table = tableContainer.querySelector(".song-table"); // Get the table
    const rows = Array.from(table.querySelectorAll("tbody tr")); // Get all rows, not just .songs-item
    const paginationControls = document.getElementById("pagination-controls");
    const rowsPerPage = 5;
    const maxPageButtons = 5;
    let currentPage = 1;
    const pageCount = Math.ceil(rows.length / rowsPerPage);

    function displayRows(page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach((row, index) => {
            // use rows instead of songs
            if (index >= start && index < end) {
                row.style.display = ""; // Show the row
            } else {
                row.style.display = "none"; // Hide the row
            }
        });
    }

    function createPaginationButton(
        text,
        pageNum,
        isActive = false,
        isDisabled = false
    ) {
        const button = document.createElement("button");
        button.innerText = text;
        if (isActive) {
            button.classList.add("active");
        }
        if (isDisabled) {
            button.disabled = true;
        }
        button.addEventListener("click", () => {
            if (!isDisabled) {
                currentPage = pageNum;
                displayRows(currentPage);
                setupPagination();
            }
        });
        return button;
    }

    function setupPagination() {
        paginationControls.innerHTML = "";

        const prevButton = createPaginationButton(
            "<",
            currentPage - 1,
            false,
            currentPage === 1
        );
        paginationControls.appendChild(prevButton);

        let startPage = Math.max(
            1,
            currentPage - Math.floor(maxPageButtons / 2)
        );
        let endPage = Math.min(pageCount, startPage + maxPageButtons - 1);

        if (endPage - startPage + 1 < maxPageButtons) {
            startPage = Math.max(1, endPage - maxPageButtons + 1);
        }

        if (startPage > 1) {
            paginationControls.appendChild(
                createPaginationButton("1", 1, currentPage === 1)
            );
            if (startPage > 2) {
                const ellipsis = document.createElement("span");
                ellipsis.innerText = "...";
                paginationControls.appendChild(ellipsis);
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            paginationControls.appendChild(
                createPaginationButton(i.toString(), i, currentPage === i)
            );
        }

        if (endPage < pageCount) {
            if (endPage < pageCount - 1) {
                const ellipsis = document.createElement("span");
                ellipsis.innerText = "...";
                paginationControls.appendChild(ellipsis);
            }
            paginationControls.appendChild(
                createPaginationButton(
                    pageCount.toString(),
                    pageCount,
                    currentPage === pageCount
                )
            );
        }

        const nextButton = createPaginationButton(
            ">",
            currentPage + 1,
            false,
            currentPage === pageCount
        );
        paginationControls.appendChild(nextButton);
    }

    setupPagination();
    displayRows(currentPage);
});
