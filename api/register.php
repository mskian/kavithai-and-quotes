<?php
include 'db.php';
include 'utils.php';

header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=63072000');
header('X-Robots-Tag: noindex, nofollow', true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!validateInput($input, ['username', 'email', 'password'])) {
        sendResponse(400, "Invalid input.");
    }

    $username = sanitizeInput($input['username']);
    $email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
    $password = $input['password'];

    if (!isValidEmail($email)) {
        sendResponse(400, "Invalid email format.");
    }

    if (!validatePassword($password)) {
        sendResponse(400, "Password must be at least 8 characters long.");
    }

    if (!validateusername ($username)) {
        sendResponse(400, "Username must be between 4 and 20 characters long.");
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $auth_key = generateAuthKey();

    try {
        $database = new Database();
        $db = $database->getConnection();

        $query = "INSERT INTO users (username, email, password, auth_key) VALUES (:username, :email, :password, :auth_key)";
        $stmt = $db->prepare($query);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':auth_key', $auth_key);

        if ($stmt->execute()) {
            $accessToken = getenv('AccessToken');
            $title = "$username - New User Registration";
            $body = "New User Registration From $username" ;
            $deviceIden = getenv('DEVICE');
            $push = sendPushbulletNotification($accessToken, $deviceIden, $title, $body);
            sendResponse(201, "Registration successful - You will recieve Email about approval status.", $push);
        } else {
            sendResponse(500, "Registration failed. Please try again later.");
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            sendResponse(409, "Username or email already exists.");
        } else {
            sendResponse(500, "Internal server error. Please try again later.");
        }
    }
} else {
    sendResponse(405, "Method not allowed.");
}
?>
