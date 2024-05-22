<?php

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function checkSession() {
    if (!isset($_SESSION['user_id']) || ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT'])) {
        session_regenerate_id(true);
        session_unset();
        session_destroy();
        sendResponse(401, "unauthorized");
    }
}

$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

?>