<?php
session_start();

define('SLASH', DIRECTORY_SEPARATOR);
require_once 'C:\xampp\htdocs\WebInfoAn2SpilevoiAnton' . SLASH . 'util' . SLASH . 'database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!isset($data['pages'], $data['book_id']) && !isset($data['external'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing pages or book_id']);
    exit;
}

$pages = (int) $data['pages'];
$bookId = (int) ($data['book_id'] ?? 0);
$external = $data['external'] ?? false;
$link = $data['link'] ?? '-';
$username = $_SESSION['user'];

$db = Database::getInstance()->getConnection();

try {
    if(!$external)
        setBookProgress($db, $bookId, $username, $pages);
    else
        setExternalBookProgress($db, $username, $pages, $link);
    echo json_encode(['status' => 'ok'.($external ? "true" : "false")]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB error: ' . $e->getMessage()]);
    exit;
}

function setExternalBookProgress($db, $user, $pages, $link)
{
    $stmt = $db->prepare("INSERT INTO books (link) VALUES (?)");
    $stmt->execute([$link]);
    
    $stmt = $db->prepare("SELECT id FROM books WHERE link = ?");
    $stmt->execute([$link]);
    $id = $stmt->fetch(PDO::FETCH_ASSOC);
    
    setBookProgress($db, $id['id'], $user, $pages);
}

function setBookProgress($db, $bookId, $user, $pages) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM progress WHERE book_id = ? AND username = ?");
    $stmt->execute([$bookId, $user]);

    if ($stmt->fetchColumn() > 0) {
        $prev = getBookProgress($db, $bookId, $user);
        $pgs = getBookPages($db, $bookId);
        $newVal = max(0, min($pgs, $prev + $pages));

        $stmt = $db->prepare("UPDATE progress SET pages = ? WHERE book_id = ? AND username = ?");
        $stmt->execute([$newVal, $bookId, $user]);
    } else {
        $stmt = $db->prepare("INSERT INTO progress (book_id, username, pages) VALUES (?, ?, ?)");
        $stmt->execute([$bookId, $user, $pages]);
    }
}

function getBookPages($db, $bookId) {
    
    $stmt = $db->prepare("SELECT link FROM books WHERE id = ?");
    $stmt->execute([$bookId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($row['link'])
    {
        return getExternalBookData($row['link'])['volumeInfo']['pageCount'];
    }

    $stmt = $db->prepare("SELECT pages FROM books WHERE id = ?");
    $stmt->execute([$bookId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);   

    return $row ? (int)$row['pages'] : 0;
}

function getBookProgress($db, $bookId, $user) {
    $stmt = $db->prepare("SELECT pages FROM progress WHERE book_id = ? AND username = ?");
    $stmt->execute([$bookId, $user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? (int)$row['pages'] : 0;
}

function getExternalBookData($link)
{
    $response = file_get_contents($link);
    $data = json_decode($response, true);
    return $data;
}

