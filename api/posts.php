<?php

include 'db.php';
include 'utils.php';

header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=63072000');
header('X-Robots-Tag: noindex, nofollow', true);

$perPage = 2;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['username'])) {
        sendResponse(400, "Username parameter is missing.");
        exit;
    }

    $username = trim($_GET['username']);
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        sendResponse(401, "Invalid username.");
        exit;
    }

    if ($page < 1) {
        sendResponse(400, "Invalid page number.");
        exit;
    }

    $offset = ($page - 1) * $perPage;

    $database = new Database();
    $db = $database->getConnection();

    if (!$db) {
        sendResponse(500, "Database connection error.");
        exit;
    }

    try {

        $stmt = $db->prepare('SELECT id, approval_status FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || $user['approval_status'] != 1) {
           sendResponse(403, "User is not approved.");
           exit;
        }

        $queryUser = "SELECT id FROM users WHERE username = :username LIMIT 1";
        $stmtUser = $db->prepare($queryUser);
        $stmtUser->bindParam(':username', $username);
        $stmtUser->execute();
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            sendResponse(404, "User ID does not exist.");
            exit;
        }

        $userId = $user['id'];
        $queryQuotes = "SELECT * FROM quotes WHERE user_id = :user_id ORDER BY date DESC LIMIT :limit OFFSET :offset";
        $stmtQuotes = $db->prepare($queryQuotes);
        $stmtQuotes->bindParam(':user_id', $userId);
        $stmtQuotes->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $stmtQuotes->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmtQuotes->execute();
        $quotes = $stmtQuotes->fetchAll(PDO::FETCH_ASSOC);

        $queryTotal = "SELECT COUNT(*) as total FROM quotes WHERE user_id = :user_id";
        $stmtTotal = $db->prepare($queryTotal);
        $stmtTotal->bindParam(':user_id', $userId);
        $stmtTotal->execute();
        $totalQuotes = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

        if (empty($quotes)) {
            sendResponse(404, "No quotes found for this user.");
            exit;
        }

        $response = [
            'user' => $username,
            'page' => $page,
            'perPage' => $perPage,
            'totalQuotes' => $totalQuotes,
            'quotes' => $quotes
        ];

        echo json_encode($response);

    } catch (PDOException $e) {
        sendResponse(500, "Internal server error. Please try again later.");
    }
} else {
    sendResponse(405, "Method not allowed.");
}

?>