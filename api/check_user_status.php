<?php
include 'session.php';
include 'utils.php';

checkSession();

header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=63072000');
header('X-Robots-Tag: noindex, nofollow', true);

if (isset($_SESSION['user_id'])) {
    $userData = array(
        'status' => true,
        'user_id' => $_SESSION['user_id'],
    );
    sendResponse(200, $userData);
} else {
    $userData = array(
        'status' => false
    );
    sendResponse(401, null, $userData);
}

?>