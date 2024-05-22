<?php
include 'db.php';
include 'utils.php';
include 'session.php';

checkSession();

header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=63072000');
header('X-Robots-Tag: noindex, nofollow', true);

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
    sendResponse(401, "Unauthorized");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!validateInput($input, ['user_id'])) {
        sendResponse(400, "Invalid input.");
    }

    $userId = intval($input['user_id']);

    try {
        $database = new Database();
        $db = $database->getConnection();

        $query = "UPDATE users SET approval_status = 1 WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $userId);

        if ($stmt->execute()) {
            sendResponse(200, "User approved.");
        } else {
            sendResponse(500, "Failed to approve user.");
        }
    } catch (PDOException $e) {
        sendResponse(500, "Internal server error. Please try again later.");
    }
} else {
    sendResponse(405, "Method not allowed.");
}

?>