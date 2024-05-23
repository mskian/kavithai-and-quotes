document.addEventListener("DOMContentLoaded", function () {
    const quoteContainer = document.getElementById("quote-container");
    const pagination = document.getElementById("pagination");
    const user = document.getElementById("user");
    let currentPage = 1;

    function fetchQuotes(username, page) {
        fetch(`/api/posts.php?username=${username}&page=${page}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.quotes && data.quotes.length > 0 && data.user) {
                    user.innerHTML = `<div class="content has-text-centered"><h1 class="title is-size-5">Posts by 👤 ${data.user}</h1></div><br>`
                    displayQuotes(data.quotes);
                    renderPagination(data.page, data.perPage, data.totalQuotes);
                } else {
                    quoteContainer.innerHTML = `<div class="notification is-warning"><p class="content has-text-centered">${data.message}</p></div>`;
                    pagination.innerHTML = "";
                }
            })
            .catch(error => { quoteContainer.innerHTML = `<div class="notidication is-danger">Data Error</p><br>`;});
    }

    function displayQuotes(quotes) {
        quoteContainer.innerHTML = "";
        quotes.forEach(quote => {
            const quoteCard = `
                        <p class="quote-text">${quote.quote_text}</p><br>
                        <p><span class="tag is-link">${quote.tags}</span><p><br>
                        <p class="quote-author">👤 ${quote.author_name} - 📅 ${quote.date}</p><hr>
                    `;
            quoteContainer.innerHTML += quoteCard;
        });
    }

    function renderPagination(page, perPage, totalQuotes) {
        const totalPages = Math.ceil(totalQuotes / perPage);
        const maxPagesToShow = 5; // Maximum number of page links to show
        const currentPageGroup = Math.ceil(page / maxPagesToShow);
        const startPage = (currentPageGroup - 1) * maxPagesToShow + 1;
        const endPage = Math.min(startPage + maxPagesToShow - 1, totalPages);

        let paginationHTML = `<ul class="pagination-list">`;

        const prevPage = Math.max(startPage - 1, 1);
        if (page > 1) {
            paginationHTML += `
    <li>
        <a class="pagination-previous" aria-label="Previous" data-page="${prevPage}">Previous</a>
    </li>
`;
        }

        for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `
    <li>
        <a class="pagination-link ${i === page ? 'is-current' : ''}" aria-label="Goto page ${i}" data-page="${i}">${i}</a>
    </li>`;
        }

        const nextPage = Math.min(endPage + 1, totalPages);
        if (page < totalPages) {
            paginationHTML += `
    <li>
        <a class="pagination-next" aria-label="Next" data-page="${nextPage}">Next</a>
    </li>
`;
        }

        paginationHTML += `</ul>`;
        pagination.innerHTML = paginationHTML;

        pagination.querySelectorAll(".pagination-link, .pagination-previous, .pagination-next").forEach(link => {
            link.addEventListener("click", () => {
                currentPage = parseInt(link.dataset.page);
                const urlParams = new URLSearchParams(window.location.search);
                const username = urlParams.get('username');
                fetchQuotes(username, currentPage);
            });
        });
    }


    // Initial fetch
    const urlParams = new URLSearchParams(window.location.search);
    const username = urlParams.get('username');
    fetchQuotes(username, currentPage);
});