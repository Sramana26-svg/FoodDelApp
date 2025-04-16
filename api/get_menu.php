<?php
header('Content-Type: application/json');
require_once '../config.php';

// Get restaurant ID from the query string
$restaurant_id = $_GET['rid'] ?? null;

if (!$restaurant_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing restaurant ID']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM menu_items WHERE restaurant_id = ?");
    $stmt->execute([$restaurant_id]);
    $menu_items = $stmt->fetchAll();

    echo json_encode($menu_items);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
