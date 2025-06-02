<?php

require_once __DIR__ . '/../util/database.php';
require_once __DIR__ . '/../util/jwt.php';

header('Content-Type: application/json');

$data = JWT::verifyAndResend();
$username = $data['username'];

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!isset($data['book_id'], $data['text'], $data['stars']) && !isset($data['external'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing pages or book_id']);
    exit;
}

$bookId = (int) ($data['book_id'] ?? 0);
$text = $data['text'];
$stars = (int) $data['stars'];
$external = $data['external'] ?? false;
$link = $data['link'] ?? '';

$db = Database::getInstance()->getConnection();

try {
    if(!$external)
        postReview($db, $bookId, $username, $text, $stars);
    else
        postReviewExternal($db, $username, $text, $stars, $link);
    echo json_encode(['status' => 'ok']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB error: ' . $e->getMessage()]);
    exit;
}

function postReview($db, $id, $user, $text, $stars) {
    $text = urldecode($text ?? '');
    $stmt = $db->prepare("
    INSERT INTO reviews (book_id, username, text, rating)
    VALUES (?, ?, ?, ?)
");

    return $stmt->execute([$id, $user, $text, $stars]);
}

function postReviewExternal($db, $user, $text, $stars, $link) {
    
    $stmt = $db->prepare("INSERT INTO books (link) VALUES (?)");
    $stmt->execute([$link]);
    
    $stmt = $db->prepare("SELECT id FROM books WHERE link = ?");
    $stmt->execute([$link]);
    $id = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $text = urldecode($text ?? '');
    $stmt = $db->prepare("
    INSERT INTO reviews (book_id, username, text, rating)
    VALUES (?, ?, ?, ?)
    ");

    return $stmt->execute([$id['id'], $user, $text, $stars]);
}
