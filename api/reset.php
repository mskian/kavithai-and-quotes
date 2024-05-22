<?php

require 'db.php';

header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=63072000');
header('X-Robots-Tag: noindex, nofollow', true);

function generateResetToken($length = 64) {
    return bin2hex(random_bytes($length / 2));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function jsonResponse($message, $status = 200, $additionalData = []) {
    header('Content-Type: application/json');
    http_response_code($status);
    $response = array_merge(['message' => $message], $additionalData);
    echo json_encode($response);
    exit;
}

function verifyApiKey($apiKey) {
    $validApiKey = getenv('APIKEY');
    return $apiKey === $validApiKey;
}

function validateToken() {
    $headers = getallheaders();
    if (isset($headers['Authorization'])) {
        $authHeader = $headers['Authorization'];
        if (strpos($authHeader, 'Bearer ') === 0) {
            $token = substr($authHeader, 7);
            return verifyApiKey($token);
        }
    }
    return false;
}

if (!validateToken()) {
    jsonResponse("Unauthorized", 401);
}

function requestPasswordReset($email) {

    $database = new Database();
    $db = $database->getConnection();

    if (!validateEmail($email)) {
        jsonResponse("Invalid email format.", 400);
    }

    $stmt = $db->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        jsonResponse("Email not found.", 404);
    }

    $resetToken = generateResetToken();
    $expiryTime = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

    $stmt = $db->prepare('UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?');
    $stmt->execute([$resetToken, $expiryTime, $email]);

    jsonResponse("Password reset token generated successfully.", 200, ['reset_token' => $resetToken]);
}

function resetPassword($token, $newPassword) {
    $database = new Database();
    $db = $database->getConnection();

    if (strlen($newPassword) < 8) {
        jsonResponse("Password must be at least 8 characters long.", 400);
    }

    if (!preg_match('/[A-Z]/', $newPassword) || !preg_match('/[a-z]/', $newPassword) || !preg_match('/\d/', $newPassword) || !preg_match('/[\W]/', $newPassword)) {
        jsonResponse("Password must include at least one uppercase letter, one lowercase letter, one number, and one special character.", 400);
    }

    $stmt = $db->prepare('SELECT id, reset_token_expiry FROM users WHERE reset_token = ?');
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        jsonResponse("Invalid reset token.", 404);
    }

    $expiryTime = new DateTime($user['reset_token_expiry']);
    $currentTime = new DateTime();

    if ($currentTime > $expiryTime) {
        jsonResponse("Reset token has expired.", 400);
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    $stmt = $db->prepare('UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?');
    $stmt->execute([$hashedPassword, $user['id']]);

    jsonResponse("Password has been successfully reset.", 200);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data === null || json_last_error() !== JSON_ERROR_NONE) {
        jsonResponse("Invalid JSON data.", 400);
    }

    if (isset($data['email'])) {
        $email = trim($data['email']);
        if (empty($email) || !validateEmail($email)) {
            jsonResponse("Invalid email address.", 400);
        }
        requestPasswordReset($email);
    } elseif (isset($data['token']) && isset($data['new_password'])) {
        $token = trim($data['token']);
        $newPassword = trim($data['new_password']);
        if (empty($token) || empty($newPassword)) {
            jsonResponse("Reset token and new password are required.", 400);
        }
        resetPassword($token, $newPassword);
    } else {
        jsonResponse("Invalid request.", 400);
    }
} else {
    jsonResponse("Invalid request method.", 405);
}

?>