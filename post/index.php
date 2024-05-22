<?php

header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=63072000');
header('X-Robots-Tag: noindex, nofollow', true);

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


<title>Submit your Kavithai and Quotes.</title>
<meta name="description" content="kavithai and Quotes Public Index Database."/>

    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css" integrity="sha512-IgmDkwzs96t4SrChW29No3NXBIBv8baW490zk5aXvhCD8vuZM3yUSkbyTBcXohkySecyzIrUwiF/qV0cuPcL3Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100..900&display=swap" rel="stylesheet">

    <style>
        html, body {
            background-color: #FDA7DF;
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

        .card {
            border-radius: 10px;
            font-family: "Catamaran", sans-serif;
        }

        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            width: 300px;
            font-family: "Catamaran", sans-serif;
        }

        .notification {
            display: none;
            animation: fadeIn 0.5s;
            font-family: "Catamaran", sans-serif;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .centered {
            display: flex;
            justify-content: center;
        }

        .button, .input, .label, select, textarea {
            font-family: "Catamaran", sans-serif;
            font-weight: 700;
        }

        .textarea {
            padding: 10px;
            border: 2px solid #4CAF50;
            border-radius: 15px;
            font-size: 16px;
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
    </style>
</head>
<body>
    <section class="section">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-half">
                    <div id="notification-container" class="notification-container"></div>
                    <div class="card">
                        <div class="card-content">
                            <!-- Login Form -->
                            <div id="login-form" style="display: none;">
                                <br>
                                <p class="is-size-5 has-text-centered">Login or Register to Submit your Kavithai and Quotes</p>
                                <hr>
                                <br>
                                <form>
                                    <div class="field">
                                        <label class="label">Username</label>
                                        <div class="control">
                                            <input class="input is-rounded" type="text" id="login-user" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Password</label>
                                        <div class="control">
                                            <input class="input is-rounded" type="password" id="login-password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="control centered">
                                        <button class="button is-primary is-rounded" type="button" onclick="loginUser()">Login</button>
                                    </div>
                                </form>
                                <br>
                            </div>
                            <hr>
                            <!-- Register Form -->
                            <div id="register-form" style="display: none;">
                                <h1 class="title is-size-5 has-text-centered">Register</h1>
                                <form>
                                    <div class="field">
                                        <label class="label">Username</label>
                                        <div class="control">
                                            <input class="input is-rounded" type="text" id="register-username" placeholder="Enter your username">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Email</label>
                                        <div class="control">
                                            <input class="input is-rounded" type="email" id="register-email" placeholder="Enter your email">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Password</label>
                                        <div class="control">
                                            <input class="input is-rounded" type="password" id="register-password" placeholder="Enter your password">
                                        </div>
                                    </div>
                                    <div class="control centered">
                                        <button class="button is-primary is-rounded" type="button" onclick="registerUser()">Register</button>
                                    </div>
                                </form>
                                <br>
                            </div>

                            <!-- Quote Posting Form -->
                            <div id="quote-form" style="display: none;">
                                <div class="field">
                                    <label class="label">Quote or Kavithai</label>
                                    <div class="control">
                                        <textarea id="quote-text" class="textarea" required rows="10" cols="50"></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="field">
                                    <label class="label">Category</label>
                                    <div class="control">
                                        <div class="select is-rounded">
                                            <select id="categorySelect">
                                                <option value="Motivation">Motivation</option>
                                                <option value="Life">Life</option>
                                                <option value="Kavithai">Kavithai</option>
                                                <option value="Kadhal">Kadhal</option>
                                                <option value="Sad">Sad</option>
                                                <option value="Love Failure">Love Failure</option>
                                                <option value="Depression">Depression</option>
                                                <option value="Friendship">Friendship</option>
                                                <option value="Wishes">Wishes</option>
                                                <option value="Thathuvam">Thathuvam</option>
                                                <option value="Jokes">Jokes</option>
                                                <option value="Relatives">Relatives</option>
                                                <option value="Nature">Nature</option>
                                                <option value="Couple">Couple</option>
                                                <option value="Oneline">Oneline</option>
                                                <option value="Father">Father</option>
                                                <option value="Mother">Mother</option>
                                                <option value="Siblings">Siblings</option>
                                                <option value="Anbu">Anbu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Author</label>
                                    <div class="control">
                                        <input class="input is-rounded" type="text" id="author-name" placeholder="Author name">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Date</label>
                                    <div class="control">
                                        <input class="input is-rounded" type="date" id="quote-date">
                                    </div>
                                </div>
                                <div class="control centered">
                                    <button class="button is-primary is-rounded" type="button" onclick="postQuote()">Post Quote</button>
                                </div>
                                <br>
                                <hr>
                                <p>For Exit or Close Posting Form - Check Logout Button</p><br>
                                <div class="control centered">
                                <button id="logoutButton" class="button is-danger is-rounded">Logout</button>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script src="/js/post.js"></script>

</body>
</html>