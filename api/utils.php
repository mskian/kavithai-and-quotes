<?php

function generateAuthKey($length = 64) {
    return bin2hex(random_bytes($length / 2));
}

function sanitizeInput($input) {
    $input = trim($input);
    $input = strip_tags($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

function sendResponse($status, $message) {
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode(['status' => $status, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

function validateInput($data, $fields) {
    foreach ($fields as $field) {
        if (!isset($data[$field]) || empty(trim($data[$field]))) {
            return false;
        }
    }
    return true;
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validatePassword($password) {
    return strlen($password) >= 8;
}

function validateUsername($username) {
    $usernameLength = strlen($username);
    return $usernameLength >= 4 && $usernameLength <= 20;
}

function sendPushbulletNotification($accessToken, $deviceIden, $title, $message) {
  
    if(empty($accessToken) || empty($deviceIden) || empty($title) || empty($message)) {
        return;
    }

    $accessToken = htmlspecialchars($accessToken, ENT_QUOTES, 'UTF-8');
    $deviceIden = htmlspecialchars($deviceIden, ENT_QUOTES, 'UTF-8');
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

    $url = 'https://api.pushbullet.com/v2/pushes';
    
    $data = [
        'type' => 'note',
        'device_iden' => $deviceIden,
        'title' => $title,
        'body' => $message
    ];

    $headers = [
        'Access-Token: ' . $accessToken,
        'Content-Type: application/json'
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

?>