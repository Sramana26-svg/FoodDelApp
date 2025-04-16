<?php
header('Content-Type: application/json');
require_once '../config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'], $data['name'], $data['price'], $data['stock'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing fields']);
    exit;
}

$stmt = $pdo->prepare("UPDATE menu_items SET name = ?, price = ?, stock = ? WHERE id = ?");
$stmt->execute([$data['name'], $data['price'], $data['stock'], $data['id']]);

echo json_encode(['success' => true, 'message' => 'Menu item updated']);
