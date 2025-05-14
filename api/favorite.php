<?php
session_start();

define('SLASH', DIRECTORY_SEPARATOR);
require_once 'C:\xampp\htdocs\WebInfoAn2SpilevoiAnton'. SLASH . 'util' . SLASH . 'database' . '.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!isset($data['book_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing book_id']);
    exit;
}

$bookId = (int) $data['book_id'];
$username = $_SESSION['user'];
$db = Database::getInstance()->getConnection();

try {
    toggleBookFavorite($db, $username, $bookId);
    echo json_encode(['status' => 'ok']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB error: ' . $e->getMessage()]);
}


function toggleBookFavorite($db, $username, $bookId) {
    if (isBookFavorite($db, $username, $bookId)) {
        $stmt = $db->prepare("DELETE FROM favorites WHERE nume = ? AND id_carte = ?");
        $stmt->execute([$username, $bookId]);
    } else {
        $stmt = $db->prepare("INSERT INTO favorites (nume, id_carte) VALUES (?, ?)");
        $stmt->execute([$username, $bookId]);
    }
}

function isBookFavorite($db, $username, $bookId) {
    $stmt = $db->prepare("SELECT 1 FROM favorites WHERE nume = ? AND id_carte = ?");
    $stmt->execute([$username, $bookId]);
    return (bool) $stmt->fetchColumn();
}