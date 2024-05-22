<?php

include 'db.php';
include 'utils.php';

header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=63072000; includeSubDomains; preload');
header('X-Robots-Tag: noindex, nofollow', true);

define('MAX_FAILED_ATTEMPTS', 2);
define('LOCKOUT_TIME', 15 * 60);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!validateInput($input, ['username', 'password'])) {
        sendResponse(400, "Invalid input. Username and password are required.");
    }

    $username = sanitizeInput($input['username']);
    $password = $input['password'];

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        sendResponse(401, "Invalid username.");
        exit;
    }

    if (strlen($password) < 8) {
        sendResponse(400, "Password too short. Minimum length is 6 characters.");
    }

    try {
        $database = new Database();
        $db = $database->getConnection();

        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $current_time = time();
            $lockout_expires = strtotime($user['last_failed_attempt']) + LOCKOUT_TIME;

            if ($user['failed_attempts'] >= MAX_FAILED_ATTEMPTS && $current_time < $lockout_expires) {
                $remaining_time = $lockout_expires - $current_time;
                sendResponse(429, "Account locked due to too many failed login attempts. Try again in " . round($remaining_time / 60) . " minutes.");
            } else {
                if (password_verify($password, $user['password'])) {
                    if ($user['approval_status'] == 1) {
                        session_start();
                        $_SESSION['user_id'] = $user['id'];

                        $update_query = "UPDATE users SET failed_attempts = 0, last_failed_attempt = NULL WHERE id = :id";
                        $update_stmt = $db->prepare($update_query);
                        $update_stmt->bindParam(':id', $user['id']);
                        $update_stmt->execute();

                        $accessToken = getenv('AccessToken');
                        $title = "New Login Detected";
                        $body = "New User Login from $username";
                        $deviceIden = getenv('DEVICE');
                        $push = sendPushbulletNotification($accessToken, $deviceIden, $title, $body);
                        sendResponse(200, "Login successful.", $push);
                    } else {
                        sendResponse(403, "Account not approved yet. Please wait for approval.");
                    }
                } else {

                    $failed_attempts = $user['failed_attempts'] + 1;
                    $update_query = "UPDATE users SET failed_attempts = :failed_attempts, last_failed_attempt = NOW() WHERE id = :id";
                    $update_stmt = $db->prepare($update_query);
                    $update_stmt->bindParam(':failed_attempts', $failed_attempts);
                    $update_stmt->bindParam(':id', $user['id']);
                    $update_stmt->execute();

                    sendResponse(401, "Invalid credentials. Please try again.");
                }
            }
        } else {
            sendResponse(401, "Invalid credentials. Please try again.");
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        sendResponse(500, "Internal server error. Please try again later.");
    }
} else {
    sendResponse(405, "Method not allowed.");
}

?>