<?php

header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=63072000');
header('X-Robots-Tag: noindex, nofollow', true);

function generateRandomString(int $length = 10): string {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateUniqueFilename(string $prefix = 'kavithai-'): string {
    $timestamp = time();
    $randomString = generateRandomString(10);
    $filename = sprintf('%s%d_%s', $prefix, $timestamp, $randomString);
    return $filename;
}

$filename = generateUniqueFilename();

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

<title>Tamil SMS - Kavithai and Quotes image Generator</title>
<meta name="description" content="Tamil SMS - Kavithai and Quotes image Generator for Social Media with 1080x1080 Dimension."/>
<?php $current_page = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; echo '<link rel="canonical" href="'.$current_page.'" />'; ?>


<link rel="preconnect" href="https://cdnjs.cloudflare.com">
<link rel="preconnect" href="https://cdn.jsdelivr.net">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css" integrity="sha512-IgmDkwzs96t4SrChW29No3NXBIBv8baW490zk5aXvhCD8vuZM3yUSkbyTBcXohkySecyzIrUwiF/qV0cuPcL3Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100..900&display=swap" rel="stylesheet">

<style>
    html, body {
        background-color: #075e54;
        padding-bottom: 20px;
        font-family: "Catamaran", sans-serif;
        font-weight: 600;
        line-height: 1.6;
        word-wrap: break-word;
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased !important;
        -moz-font-smoothing: antialiased !important;
        text-rendering: optimizeLegibility !important;
    }

    /* Styles for the quotes box */
    .quotes-box {
        width: 1080px;
        height: 1080px;
        background-color: #160808;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: justify; /* Justify text */
        margin: 0 auto; /* Center the box */
        background-image: url('/canva/background.png'); /* Replace with your image URL */
        background-size: cover;
        position: relative;
    }

    /* Styles for the quote text */
    .quote-text {
        font-family: "Catamaran", sans-serif;
        font-weight: 700;
        font-size: 35px;
        line-height: 1.6;
        color: #F2E3B6;
        margin-bottom: 30px;
        word-wrap: break-word; /* Word wrap */
        white-space: pre-line;
        margin-top: var(--margin-top); /* Dynamic margin top */
        margin-bottom: var(--margin-bottom); /* Dynamic margin bottom */
    }

    /* Styles for the author */
    .author {
        font-family: "Catamaran", sans-serif;
        font-size: 28px;
        font-style: italic;
        color: #666;
    }
    /* Styles for the close button */
    .delete {
        position: absolute;
        top: 0;
        right: 0;
        cursor: pointer;
    }
    .canvas-output {
        width: 100%;
        height: auto;
    }
    .hide-me {
        visibility: none;
        max-height: 0;
        overflow: hidden;
    }
    #quote-container {
        background-color: #fff;
    }
    #quote {
        margin-bottom: 20px;
        color: #333;
    }
    #quote-card {
        font-family: "Catamaran", sans-serif;
        max-width: 800px;
        margin: 10px auto;
    }
    button {
        font-family: "Catamaran", sans-serif;
        display: flex;
        flex-grow: 0.3;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        border-radius: 32px;
        padding: 12px;
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased !important;
        -moz-font-smoothing: antialiased !important;
        text-rendering: optimizeLegibility !important;
    }
    input {
        font-family: "Catamaran", sans-serif;
    }
    .textarea {
      padding: 10px;
      border: 2px solid #4CAF50;
      border-radius: 15px;
      font-size: 16px;
      font-weight: 700;
      outline: none;
      transition: border-color 0.3s;
      resize: vertical;
      min-height: 100px;
    }
    .textarea:hover {
      border-color: #45a049;
    }
    .textarea:focus {
      border-color: #2196F3;
      box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
    }
    textarea {
       font-family: "Catamaran", sans-serif;
    }
    ::-webkit-input-placeholder {
       font-family: "Catamaran", sans-serif;
    }
    ::-moz-placeholder {
       font-family: "Catamaran", sans-serif;
    }
    :-ms-input-placeholder {
       font-family: "Catamaran", sans-serif;
    }
    :-moz-placeholder {
       font-family: "Catamaran", sans-serif;
    }
</style>

</head>
<body>

    <section class="section">
        <div class="container">
            <div id="quote-card" class="card">
                <div class="card-content">
                    <div id="quote-container">
                    
    <div class="notification is-primary is-light" id="notification" style="display: none;">
        <button class="delete" onclick="hideNotification()"></button>
        <span id="notification-message"></span>
    </div>

     <!-- Input form for adding quotes -->
     <form id="quote-form">
        <div class="field">
            <label class="label" for="quote">Text:</label>
            <div class="control">
                <textarea class="textarea" id="quote" name="quote" rows="10"></textarea>
            </div>
        </div>
        <div class="field">
            <label class="label" for="font-size">Font Size:</label>
            <div class="control">
                <input class="input" type="number" id="font-size" name="font-size" min="10" max="100" value="35">
            </div>
        </div>
        <div class="field">
            <label class="label" for="margin-top">Margin Top:</label>
            <div class="control">
                <input class="input" type="number" id="margin-top" name="margin-top" min="0" max="150" value="1">
            </div>
        </div>
        <div class="field">
            <label class="label" for="margin-bottom">Margin Bottom:</label>
            <div class="control">
                <input class="input" type="number" id="margin-bottom" name="margin-bottom" min="0" max="150" value="1">
            </div>
        </div>
        <div class="field">
            <div class="control">
                <div class="buttons is-centered">
                <button class="button is-primary" type="submit">Update image</button>
            </div>
            </div>
        </div>
    </form>

    <hr>
    <!-- Button to trigger download -->
    <div id="download-image" style="display: none;">
    <div class="buttons is-centered">
    <button class="button is-info" onclick="downloadImage()">Download Image</button>
    </div>
    </div>
    <br>

<div class="hide-me">
<div class="quotes-box" id="quote-box">
<p class="quote-text" id="quote-text">
தன்னம்பிக்கை
இல்லாத வாழ்க்கை
சுகர் இல்லாத காஃபி
மாதிரி தான்
என்ன தான்
வாசமா இருந்தாலும்
ருசியா இருக்காது
</p>
</div>
</div>
<img id="canvas-output" src="" style="display: none;"><br>
</div>
</div>
</div>
</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js" integrity="sha256-6H5VB5QyLldKH9oMFUmjxw2uWpPZETQXpCkBaDjquMs=" crossorigin="anonymous"></script>

<script>
    function updateQuote(event) {
        event.preventDefault();
        var quote = document.getElementById('quote').value;
        var fontSize = document.getElementById('font-size').value;
        var marginTop = document.getElementById('margin-top').value;
        var marginBottom = document.getElementById('margin-bottom').value;
        var quoteText = document.getElementById('quote-text');

        if (!quote || !fontSize || isNaN(fontSize) || fontSize < 10 || fontSize > 100) {
            showNotification('Please enter a valid quote and font size between 10 and 100.', 'is-danger');
            return;
        }

        if (isNaN(marginTop) || marginTop < 0 || marginTop > 150) {
            showNotification('Please enter a valid margin top between 0 and 150.', 'is-danger');
            return;
        }

        marginTop = marginTop + 'px';
        marginBottom = marginBottom + 'px';

        quoteText.innerText = quote;
        quoteText.style.fontSize = fontSize + 'px';
        quoteText.style.setProperty('--margin-top', marginTop);
        quoteText.style.setProperty('--margin-bottom', marginBottom);

        localStorage.setItem('quote', quote);
        localStorage.setItem('fontSize', fontSize);
        localStorage.setItem('marginTop', marginTop);
        localStorage.setItem('marginBottom', marginBottom);

        const download = document.getElementById('download-image');
        download.style.display = 'block';

        CImage();
    }

    document.getElementById('quote-form').addEventListener('submit', updateQuote);
    document.getElementById('quote').addEventListener('input', saveToLocalStorage);
    document.getElementById('font-size').addEventListener('input', saveToLocalStorage);
    document.getElementById('margin-top').addEventListener('input', saveToLocalStorage);
    document.getElementById('margin-bottom').addEventListener('input', saveToLocalStorage);

    function saveToLocalStorage() {
        var quote = document.getElementById('quote').value;
        var fontSize = document.getElementById('font-size').value;
        var marginTop = document.getElementById('margin-top').value;
        var marginBottom = document.getElementById('margin-bottom').value;

        localStorage.setItem('quote', quote);
        localStorage.setItem('fontSize', fontSize);
        localStorage.setItem('marginTop', marginTop);
        localStorage.setItem('marginBottom', marginBottom);
    }

    function restoreFromLocalStorage() {
        var quote = localStorage.getItem('quote');
        var fontSize = localStorage.getItem('fontSize');
        var marginTop = localStorage.getItem('marginTop');
        var marginBottom = localStorage.getItem('marginBottom');

        if (quote) document.getElementById('quote').value = quote;
        if (fontSize) document.getElementById('font-size').value = fontSize;
        if (marginTop) document.getElementById('margin-top').value = parseInt(marginTop, 10);
        if (marginBottom) document.getElementById('margin-bottom').value = parseInt(marginBottom, 10);
    }

    function CImage() {
        var scale = 1080 / document.querySelector('.quotes-box').offsetWidth;

        html2canvas(document.getElementById('quote-box'), {
            allowTaint: true,
            useCORS: true,
            scale: scale,
            logging: false,
        }).then(function(canvas) {
            var canvasOutput = document.getElementById('canvas-output');
            canvasOutput.src = canvas.toDataURL("image/png", 1);
            canvasOutput.style.display = 'block';

        });
    }

    function downloadImage() {
        var scale = 1080 / document.querySelector('.quotes-box').offsetWidth;

        html2canvas(document.getElementById('quote-box'), {
            allowTaint: true,
            useCORS: true,
            scale: scale,
            logging: false,
        }).then(function(canvas) {
            var link = document.createElement('a');
            link.download = '<?php echo $filename; ?>';
            link.href = canvas.toDataURL("image/png", 1);
            link.click();

        });
    }

    function showNotification(message, type) {
        var notification = document.getElementById('notification');
        var notificationMessage = document.getElementById('notification-message');

        notificationMessage.innerText = message;
        notification.className = 'notification ' + type + ' is-light';
        notification.style.display = 'block';
    }

    function hideNotification() {
        var notification = document.getElementById('notification');
        notification.style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', restoreFromLocalStorage);

</script>

</body>
</html>