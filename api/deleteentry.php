<?php

require_once __DIR__ . '/../util/database.php';
require_once __DIR__ . '/../util/jwt.php';

header('Content-Type: application/json');

if (!isset($_COOKIE['is_admin']) || $_COOKIE['is_admin'] !== '1') {
    http_response_code(403);
    echo json_encode(['error' => 'Not authorized']);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['table']) || !isset($input['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$table = $input['table'];
$id = $input['id'];
$allowedTables = ['books', 'users', 'favorites', 'progress', 'reviews']; 

if (!in_array($table, $allowedTables)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid table']);
    exit;
}

try {
    $db = Database::getInstance()->getConnection();

    $stmt = $db->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['status' => 'ok']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB error: ' . $e->getMessage()]);
}
