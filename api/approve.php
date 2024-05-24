<?php

include 'db.php';
include 'utils.php';
include 'email_check.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=63072000');
header('X-Robots-Tag: noindex, nofollow', true);

function verifyApiKey($apiKey) {
    $validApiKey = getenv('APIKEY');
    return hash_equals($validApiKey, $apiKey);
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

function userIdExists($db, $userId) {
    $query = "SELECT id FROM users WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
}

function getUserEmail($db, $userEmail) {
    try {
        $userEmail = filter_var($userEmail, FILTER_VALIDATE_INT);

        if ($userEmail === false) {
            throw new InvalidArgumentException("Invalid user ID.");
        }

        $query = "SELECT email FROM users WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $userEmail, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['email'] : null;
    } catch (Exception $e) {
        error_log("Failed to get user email: " . $e->getMessage());
        return null;
    }
}

function isUserApproved($db, $userId) {
    $query = "SELECT approval_status FROM users WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result && $result['approval_status'] == 1;
}

function sendEmailUpdate($to, $subject, $message) {

    if(empty($to) || empty($subject) || empty($message)) {
        return;
    }

    $to = sanitizeInput($to);
    $subject = sanitizeInput($subject);
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = getenv('SMPT');
        $mail->SMTPAuth = true;
        $mail->Username = getenv('USERNAME');
        $mail->Password = getenv('PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom(getenv('EMAIL'), getenv('TITLE'));
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->send();

    } catch (Exception $e) {

        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    
    }
}

if (!validateToken()) {
    sendResponse(401, "Unauthorized");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!validateInput($input, ['user_id']) || !is_numeric($input['user_id'])) {
        sendResponse(400, "Invalid input.");
        exit();
    }

    $userId = intval($input['user_id']);

    try {
        $database = new Database();
        $db = $database->getConnection();

        if (!userIdExists($db, $userId)) {
            sendResponse(404, "User not found.");
            exit();
        }

        if (isUserApproved($db, $userId)) {
            sendResponse(400, "User is already approved.");
            exit();
        }

        $query = "UPDATE users SET approval_status = 1 WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $userEmail = $userId;
            $email = getUserEmail($db, $userEmail);
            $subject = 'Kavithai and Quotes - Your Account was Approved';
            $message = 'Approved : Thank you for showing your interest to Submit Kavithai and Quotes to our Public Index database.';
            $pushEmail = sendEmailUpdate($email, $subject, $message);

            if ($email && checkValidEmail($email, $disposableEmailDomains)) {
                sendResponse(200, "User approved.", $pushEmail);
            } else {
                sendResponse(400, 'Invalid user ID or email address.');
            }

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