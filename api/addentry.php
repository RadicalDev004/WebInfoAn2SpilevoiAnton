<?php

define('SLASH', DIRECTORY_SEPARATOR);
require_once 'C:\xampp\htdocs\WebInfoAn2SpilevoiAnton'. SLASH . 'util' . SLASH . 'database' . '.php';
require_once 'C:\xampp\htdocs\WebInfoAn2SpilevoiAnton' . SLASH . 'util' . SLASH . 'jwt.php';

header('Content-Type: application/json');

if (!isset($_COOKIE['is_admin']) || $_COOKIE['is_admin'] !== '1') {
    http_response_code(403);
    echo json_encode(['error' => 'Not authorized']);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['table']) || !isset($input['entry']) || !is_array($input['entry'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$table = $input['table'];
$entry = $input['entry'];

try {
    $db = Database::getInstance()->getConnection();

    $stmt = $db->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
    $allowedTables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (!in_array($table, $allowedTables)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid table']);
        exit;
    }

    $columns = array_keys($entry);
    $placeholders = array_fill(0, count($columns), '?');
    $sql = 'INSERT INTO "' . $table . '" (' . implode(',', $columns) . ') VALUES (' . implode(',', $placeholders) . ')';

    $stmt = $db->prepare($sql);
    $stmt->execute(array_values($entry));

    echo json_encode(['status' => 'ok']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB error: ' . $e->getMessage()]);
}
