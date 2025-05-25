<?php

define('SLASH', DIRECTORY_SEPARATOR);
require_once 'C:\xampp\htdocs\WebInfoAn2SpilevoiAnton'. SLASH . 'util' . SLASH . 'database' . '.php';
require_once 'C:\xampp\htdocs\WebInfoAn2SpilevoiAnton' . SLASH . 'util' . SLASH . 'jwt.php';

header('Content-Type: application/json');

$data = JWT::verifyAndResend();
$username = $data['username'];

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!isset($data['book_id']) && !isset($data['external'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing book_id']);
    exit;
}

$bookId = (int) ($data['book_id'] ?? -1);

$db = Database::getInstance()->getConnection();

try {
    toggleBookFavorite($db, $username, $bookId, $data['external'] ?? '', $data['link'] ?? '');
    echo json_encode(['status' => 'ok']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB error: ' . $e->getMessage()]);
}


function toggleBookFavorite($db, $username, $bookId, $external, $link) {
    if($external != '') {
        if(!isBookPresentLink($db, $link)) {
            insertExternalBook($db, $link);
        }
        $bookId = getExternalBookId($db, $link);
    }
    
    
    if (isBookFavorite($db, $username, $bookId)) {
        $stmt = $db->prepare("DELETE FROM favorites WHERE name = ? AND book_id = ?");
        $stmt->execute([$username, $bookId]);
    } else {
        $stmt = $db->prepare("INSERT INTO favorites (name, book_id) VALUES (?, ?)");
        $stmt->execute([$username, $bookId]);
    }
}

function isBookFavorite($db, $username, $bookId) {
    $stmt = $db->prepare("SELECT 1 FROM favorites WHERE name = ? AND book_id = ?");
    $stmt->execute([$username, $bookId]);
    return (bool) $stmt->fetchColumn();
}

function isBookPresent($db, $bookId) {
    $stmt = $db->prepare("SELECT 1 FROM books WHERE id = ?");
    $stmt->execute([$bookId]);
    return (bool) $stmt->fetchColumn();
}

function isBookPresentLink($db, $link) {
    $stmt = $db->prepare("SELECT 1 FROM books WHERE link = ?");
    $stmt->execute([$link]);
    return (bool) $stmt->fetchColumn();
}

function insertExternalBook($db, $link) {
    $stmt = $db->prepare("INSERT INTO books (link) VALUES (?)");
    $stmt->execute([$link]);
}

function getExternalBookId($db, $link) {
    $stmt = $db->prepare("SELECT id FROM books WHERE link = ?");
    $stmt->execute([$link]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['id'] ?? 0;
}