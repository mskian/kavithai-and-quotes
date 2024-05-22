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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $requiredFields = ['quote_text', 'author_name', 'date', 'tags'];
    if (!validateInput($input, $requiredFields)) {
        sendResponse(400, "Required fields are missing.");
    }

    $quoteText = sanitizeInput($input['quote_text']);
    $authorName = sanitizeInput($input['author_name']);
    $date = sanitizeInput($input['date']);
    $tags = isset($input['tags']) ? sanitizeInput($input['tags']) : '';

    if (strlen($quoteText) > 1000) {
        sendResponse(400, "Quote text must be less than or equal to 1000 characters.");
    }

    if (!isValidDateFormat($date)) {
        sendResponse(400, "Invalid date format. Date must be in YYYY-MM-DD format.");
    }

    $database = new Database();
    $db = $database->getConnection();

    if (!$db) {
        sendResponse(500, "Database connection error.");
    }

    try {
        $query = "SELECT id FROM quotes WHERE quote_text = :quote_text LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':quote_text', $quoteText);
        $stmt->execute();
        $existingQuote = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingQuote) {
            sendResponse(409, "Quote already exists.");
        } else {
            $query = "INSERT INTO quotes (quote_text, author_name, date, tags, user_id) VALUES (:quote_text, :author_name, :date, :tags, :user_id)";
            $stmt = $db->prepare($query);

            $stmt->bindParam(':quote_text', $quoteText);
            $stmt->bindParam(':author_name', $authorName);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':tags', $tags);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);

            if ($stmt->execute()) {
                $accessToken = getenv('AccessToken');
                $title = "New Post Submitted";
                $body = "New Post from " . $_SESSION['user_id'];
                $deviceIden = getenv('DEVICE');
                $push = sendPushbulletNotification($accessToken, $deviceIden, $title, $body);
                sendResponse(201, "Quote submitted successfully.", $push);
            } else {
                sendResponse(500, "Failed to submit quote. Please try again later.");
            }
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        sendResponse(500, "Internal server error. Please try again later.");
    }
} else {
    sendResponse(405, "Method not allowed.");
}

function isValidDateFormat($date) {
    return preg_match("/^\d{4}-\d{2}-\d{2}$/", $date);
}

?>