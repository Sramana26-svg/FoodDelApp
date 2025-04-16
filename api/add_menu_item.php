<?php
header('Content-Type: application/json');
require_once '../config.php';

// Read JSON data from request
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($data['restaurant_id'], $data['name'], $data['price'], $data['stock'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

try {
    // Insert the new menu item
    $stmt = $pdo->prepare("INSERT INTO menu_items (restaurant_id, name, price, stock) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $data['restaurant_id'],
        $data['name'],
        $data['price'],
        $data['stock']
    ]);

    echo json_encode(['success' => true, 'message' => 'Menu item added successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
