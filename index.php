<?php

header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=63072000');
header('X-Robots-Tag: noindex, nofollow', true);

if(isset($_GET['username']) && $_GET['username'] !== '') {
    $username = htmlspecialchars(trim($_GET['username']));
} else {
    $username = "tamilsms";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="HandheldFriendly" content="True" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#c7ecee">
<link rel="shortcut icon" href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAA7EAAAOxAGVKw4bAAABqklEQVQ4jZ2Tv0scURDHP7P7SGWh14mkuXJZEH8cgqUWcklAsLBbCEEJSprkD7hD/4BUISHEkMBBiivs5LhCwRQBuWgQji2vT7NeYeF7GxwLd7nl4knMwMDMfL8z876P94TMLt+8D0U0EggQSsAjwMvga8ChJAqxqjTG3m53AQTg4tXHDRH9ABj+zf6oytbEu5d78nvzcyiivx7QXBwy46XOi5z1jbM+Be+nqVfP8yzuD3FM6rzIs9YE1hqGvDf15cVunmdx7w5eYJw1pcGptC9CD4gBUuef5Ujq/BhAlTLIeFYuyfmTZgeYv+2nPt1a371P+Hm1WUPYydKf0lnePwVmh3hnlcO1uc7yvgJUDtdG8oy98kduK2KjeHI0fzCQINSXOk/vlXBUOaihAwnGWd8V5r1uhe1VIK52V6JW2D4FqHZX5lphuwEE7ooyaN7gjLMmKSwYL+pMnV+MA/6+g8RYa2Lg2RBQbj4+rll7uymLy3coiuXb5PdQVf7rKYvojAB8Lf3YUJUHfSYR3XqeLO5JXvk0dhKqSqQQoCO+s5AIxCLa2Lxc6ALcAPwS26XFskWbAAAAAElFTkSuQmCC" />
<?php $current_page = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; echo '<link rel="canonical" href="'.$current_page.'" />'; ?>


    <title><?php echo $username; ?>'s Quotes and Kavithai</title>
    <meta name="description" content="kavithai and Quotes Public Index - Our database collects kavithai and quotes from users - Users can submit their kavithai and quotes to the database."/>

    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css" integrity="sha512-IgmDkwzs96t4SrChW29No3NXBIBv8baW490zk5aXvhCD8vuZM3yUSkbyTBcXohkySecyzIrUwiF/qV0cuPcL3Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css"> 

</head>
<body>

<section class="section">
    <div class="container">
            <div id="user"></div>
                <div id="quote-container"></div>
                <div class="content has-text-centered">
                <div id="pagination" class="pagination is-centered" role="navigation" aria-label="pagination"></div>
            </div>
    </div>
</section>

<script>
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
                    user.innerHTML = `<div class="content has-text-centered"><h1 class="title is-size-5 has-text-warning">Posts by 👤 ${data.user}</h1></div>`
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
                        <div class="chat-box">
                        <div class="quote-card">
                        <div class="quote-text">
                          ${quote.quote_text}
                        </div>
                        <br>
                        <div class="quote-author">👤 ${quote.author_name}</div>
                        <div class="quote-date">📅 ${quote.date}</div>
                        <div class="quote-tags">#${quote.tags}</div>
                        </div>
                        </div>
                        </div>`;
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
        <a class="pagination-previous button is-warning" aria-label="Previous" data-page="${prevPage}">Previous</a>
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
        <a class="pagination-next button is-warning" aria-label="Next" data-page="${nextPage}">Next</a>
    </li>
`;
        }

        paginationHTML += `</ul>`;
        pagination.innerHTML = paginationHTML;

        pagination.querySelectorAll(".pagination-link, .pagination-previous, .pagination-next").forEach(link => {
            link.addEventListener("click", () => {
                currentPage = parseInt(link.dataset.page);
               // const urlParams = new URLSearchParams(window.location.search);
                const username = "<?php echo $username; ?>";
                fetchQuotes(username, currentPage);
            });
        });
    }


    // Initial fetch
    //const urlParams = new URLSearchParams(window.location.search);
    const username = "<?php echo $username; ?>";
    fetchQuotes(username, currentPage);
});
</script>

</body>
</html>