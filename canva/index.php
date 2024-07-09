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

$imageOptions = [
    'normal' => [
        'background' => '/canva/background.png',
        'alt' => 'Tamil SMS kavithai'
    ],
    'love' => [
        'background' => '/canva/love.png',
        'alt' => 'Tamil SMS Kadhal'
    ],
    'tamilsms' => [
        'background' => '/canva/tamilsms.png',
        'alt' => 'Tamil SMS'
    ],
    'tamilsmsone' => [
        'background' => '/canva/tamilsmsone.png',
        'alt' => 'Tamil SMS Social Share'
    ],
    'yellow' => [
        'background' => '/canva/yellow.png',
        'alt' => 'Yellow'
    ],
    'mercury' => [
        'background' => '/canva/mercury.png',
        'alt' => 'Mercury'
    ],
    'blogone' => [
        'background' => '/canva/tamilsms-blog-one.jpg',
        'alt' => 'Blog one'
    ],
    'blogtwo' => [
        'background' => '/canva/tamilsms-blog-two.jpg',
        'alt' => 'Blog Two'
    ]
];

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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@melloware/coloris@0.22.0/dist/coloris.min.css" integrity="sha256-/l5LFjgUyBUmByCzNvkmdbwGU67dxic3wXL7mncTorA=" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@melloware/coloris@0.22.0/dist/umd/coloris.min.js" integrity="sha256-ww4FjsGboXzCDLqjt6L3OOsIfm8riBKxyLb6QX181XU=" crossorigin="anonymous"></script>

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
    .user-button {
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
    select {
        font-family: "Catamaran", sans-serif;
        font-weight: 700;
    }
    .picker {
      width: 130px;
      height: 30px;
      padding: 0 10px;
      border: 1px solid #ccc;
      border-radius: 1px;
      font-family: inherit;
      font-size: inherit;
      font-weight: inherit;
      box-sizing: border-box;
    }
    input[type="number"] {
      padding: 10px;
      border: 2px solid #4CAF50;
      border-radius: 15px;
      font-size: 16px;
      outline: none;
      transition: border-color 0.3s;
    }

  input[type="number"]:hover {
    border-color: #999;
  }

  input[type="number"]:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
  }
  input[type=number] {
	    width: 5em;
	    padding: 0.5em;
	    border: .2em solid #E91E63;
	    border-radius: 1em;
	    text-align: center;
	    color: #E91E63;
	    appearance: textfield;
	    margin: 0;
	    &::-webkit-inner-spin-button {
		  opacity: 1;
	   	background: red;
	  }
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
                <input class="input is-rounded" type="number" id="font-size" name="font-size" min="10" max="100" value="35">
            </div>
        </div>
        <div class="field">
           <label class="label">Font Color:</label>
           <div class="control">
           <input type="text" id="font-color" class="picker color-picker" value="#F2E3B6" data-coloris>
          </div>
        </div>
        <div class="field">
            <label class="label" for="margin-top">Margin Top:</label>
            <div class="control">
                <input class="input is-rounded" type="number" id="margin-top" name="margin-top" min="0" max="150" value="1">
            </div>
        </div>
        <div class="field">
            <label class="label" for="margin-bottom">Margin Bottom:</label>
            <div class="control">
                <input class="input is-rounded" type="number" id="margin-bottom" name="margin-bottom" min="0" max="150" value="1">
            </div>
        </div>
        <div class="field">
        <label class="label" for="post-type">Post Template:</label>
        <div class="control">
        <div class="select is-rounded">
            <select id="post-type" name="post-type">
                <option value="normal">Normal Post</option>
                <option value="love">Love Post</option>
                <option value="tamilsms">Tamil SMS</option>
                <option value="tamilsmsone">Tamil SMS One</option>
                <option value="yellow">Yellow</option>
                <option value="mercury">Mercury</option>
                <option value="blogone">Blog One</option>
                <option value="blogtwo">Blog Two</option>
            </select>
           </div>
         </div>
       </div>
       <div class="columns is-centered">
       <div class="column is-half">
       <div id="preview-image-container" style="position: relative;">
       <img id="preview-image" src="" alt="Preview Image" style="max-width: 100%; height: auto; display: none;">
       <!---<p id="demo-preview-text" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 20px; text-align: center; display: none;">Preview Text</p>--->
       </div>
       </div>
       </div>
       <br>
        <div class="field">
            <div class="control">
                <div class="buttons is-centered">
                <button class="button is-warning user-button is-rounded" type="submit">Create</button>
            </div>
            </div>
        </div>
    </form>

    <hr>

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
<div class="columns is-centered">
<div class="column is-half">
<img id="canvas-output" src="" style="display: none;">
</div>
</div>
<div id="download-image" style="display: none;">
<div class="buttons is-centered">
<button class="button is-link is-rounded user-button" onclick="downloadImage()">Download</button>
</div>
</div>
<br>
</div>
</div>
</div>
</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js" integrity="sha256-6H5VB5QyLldKH9oMFUmjxw2uWpPZETQXpCkBaDjquMs=" crossorigin="anonymous"></script>

<script>
 Coloris({
  themeMode: 'dark',
  alpha: false,
  formatToggle: true,
  el: '.coloris',
      swatches: [
        '#F2E3B6',
        '#000000',
        '#264653',
        '#114646',
        '#E9D5FF',
        '#f4a261',
        '#dfe6e9',
        '#d62828',
        '#023e8a',
        '#0077b6',
        '#FEF08A',
        '#00b4d8',
        '#48cae4'
      ]
});
function updateQuote(event) {
    event.preventDefault();
    const postType = document.getElementById('post-type').value;
    const quote = document.getElementById('quote').value;
    const fontSize = document.getElementById('font-size').value;
    const marginTop = document.getElementById('margin-top').value;
    const marginBottom = document.getElementById('margin-bottom').value;
    const fontColor = document.getElementById('font-color').value; 
    const quoteText = document.getElementById('quote-text');

    let backgroundImage = '<?php echo $imageOptions['normal']['background']; ?>';
    if (postType === 'love') {
        backgroundImage = '<?php echo $imageOptions['love']['background']; ?>';
    } else if (postType === 'tamilsms') {
        backgroundImage = '<?php echo $imageOptions['tamilsms']['background']; ?>';
    } else if (postType === 'tamilsmsone') {
        backgroundImage = '<?php echo $imageOptions['tamilsmsone']['background']; ?>';
    } else if (postType === 'yellow') {
        backgroundImage = '<?php echo $imageOptions['yellow']['background']; ?>';
    } else if (postType === 'mercury') {
        backgroundImage = '<?php echo $imageOptions['mercury']['background']; ?>';
    } else if (postType === 'blogone') {
        backgroundImage = '<?php echo $imageOptions['blogone']['background']; ?>';
    } else if (postType === 'blogtwo') {
        backgroundImage = '<?php echo $imageOptions['blogtwo']['background']; ?>';
    } else {
        backgroundImage = '<?php echo $imageOptions['normal']['background']; ?>';
    }
  
    if (!quote || !fontSize || isNaN(fontSize) || fontSize < 10 || fontSize > 100) {
        showNotification('Please enter a valid quote and font size between 10 and 100.', 'is-danger');
        return;
    }

    if (isNaN(marginTop) || marginTop < 0 || marginTop > 150) {
        showNotification('Please enter a valid margin top between 0 and 150.', 'is-danger');
        return;
    }

    const marginTopPx = marginTop + 'px';
    const marginBottomPx = marginBottom + 'px';

    quoteText.innerText = quote;
    quoteText.style.fontSize = fontSize + 'px';
    quoteText.style.setProperty('--margin-top', marginTopPx);
    quoteText.style.setProperty('--margin-bottom', marginBottomPx);
    quoteText.style.color = fontColor;
    
    document.querySelector('.quotes-box').style.backgroundImage = 'url(' + backgroundImage + ')';
    const download = document.getElementById('download-image');
    const previewImage = document.getElementById('preview-image');
    download.style.display = 'block';
    previewImage.style.display = 'none';
    CImage();
}

document.getElementById('quote-form').addEventListener('submit', updateQuote);
document.getElementById('quote').addEventListener('input', saveToLocalStorage);
document.getElementById('font-size').addEventListener('input', saveToLocalStorage);
document.getElementById('margin-top').addEventListener('input', saveToLocalStorage);
document.getElementById('margin-bottom').addEventListener('input', saveToLocalStorage);
document.getElementById('post-type').addEventListener('input', saveToLocalStorage);
document.getElementById('font-color').addEventListener('input', saveToLocalStorage);

 document.getElementById('post-type').addEventListener('change', function () {
        const postType = this.value;
        const previewImage = document.getElementById('preview-image');
        //const demoPreviewText = document.getElementById('demo-preview-text');

        if (postType === 'normal') {
            previewImage.src = '<?php echo $imageOptions['normal']['background']; ?>';
        } else if (postType === 'love') {
            previewImage.src = '<?php echo $imageOptions['love']['background']; ?>';
        } else if (postType === 'tamilsms') {
            previewImage.src = '<?php echo $imageOptions['tamilsms']['background']; ?>';
        } else if (postType === 'tamilsmsone') {
            previewImage.src = '<?php echo $imageOptions['tamilsmsone']['background']; ?>';
        } else if (postType === 'yellow') {
            previewImage.src = '<?php echo $imageOptions['yellow']['background']; ?>';
        } else if (postType === 'mercury') {
            previewImage.src = '<?php echo $imageOptions['mercury']['background']; ?>';
        } else if (postType === 'blogone') {
            previewImage.src = '<?php echo $imageOptions['blogone']['background']; ?>';
        } else if (postType === 'blogtwo') {
            previewImage.src = '<?php echo $imageOptions['blogtwo']['background']; ?>';
        }

        //if (postType === 'normal') {
        //    demoPreviewText.innerText = 'Normal Post Preview';
        //} else if (postType === 'love') {
        //    demoPreviewText.innerText = 'Love Post Preview';
       // } else if (postType === 'tamilsms') {
       //     demoPreviewText.innerText = 'Tamil SMS Preview';
       // }

        previewImage.style.display = 'block';
       // demoPreviewText.style.display = 'block';
        const download = document.getElementById('download-image');
        download.style.display = 'none';
        const canvasOutput = document.getElementById('canvas-output');
        canvasOutput.style.display = 'none';

    });

function saveToLocalStorage() {
    const quote = document.getElementById('quote').value;
    const fontSize = document.getElementById('font-size').value;
    const fontcolor = document.getElementById('font-color').value;
    const marginTop = document.getElementById('margin-top').value;
    const marginBottom = document.getElementById('margin-bottom').value;
    const postType = document.getElementById('post-type').value;

    localStorage.setItem('quote', quote);
    localStorage.setItem('fontSize', fontSize);
    localStorage.setItem('fontcolor',  fontcolor);
    localStorage.setItem('marginTop', marginTop);
    localStorage.setItem('marginBottom', marginBottom);
    localStorage.setItem('image', postType);
}

function restoreFromLocalStorage() {
    const quote = localStorage.getItem('quote');
    const fontSize = localStorage.getItem('fontSize');
    const fontColor = localStorage.getItem('fontcolor');
    const marginTop = localStorage.getItem('marginTop');
    const marginBottom = localStorage.getItem('marginBottom');
    const postType = localStorage.getItem('image');

    if (quote) document.getElementById('quote').value = quote;
    if (fontSize) document.getElementById('font-size').value = fontSize;
    if (fontColor) document.getElementById('font-color').value = fontColor;
    if (postType) document.getElementById('post-type').value = postType;
    if (marginTop) document.getElementById('margin-top').value = parseInt(marginTop, 10);
    if (marginBottom) document.getElementById('margin-bottom').value = parseInt(marginBottom, 10);
}

function CImage() {
    const scale = 1080 / document.querySelector('.quotes-box').offsetWidth;

    html2canvas(document.getElementById('quote-box'), {
        allowTaint: true,
        useCORS: true,
        scale: scale,
        logging: false,
    }).then(function(canvas) {
        const canvasOutput = document.getElementById('canvas-output');
        canvasOutput.src = canvas.toDataURL("image/png", 1);
        canvasOutput.style.display = 'block';

    });
}

function downloadImage() {
    const scale = 1080 / document.querySelector('.quotes-box').offsetWidth;

    html2canvas(document.getElementById('quote-box'), {
        allowTaint: true,
        useCORS: true,
        scale: scale,
        logging: false,
    }).then(function(canvas) {
        const link = document.createElement('a');
        link.download = '<?php echo $filename; ?>';
        link.href = canvas.toDataURL("image/png", 1);
        link.click();

    });
}

function showNotification(message, type) {
    const notification = document.getElementById('notification');
    const notificationMessage = document.getElementById('notification-message');

    notificationMessage.innerText = message;
    notification.className = 'notification ' + type + ' is-light';
    notification.style.display = 'block';
}

function hideNotification() {
    const notification = document.getElementById('notification');
    notification.style.display = 'none';
}

document.addEventListener('DOMContentLoaded', restoreFromLocalStorage);
</script>

</body>
</html>