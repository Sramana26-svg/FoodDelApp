<?php
header('Content-Type: application/json');
require_once '../config.php';

// Expect menu item ID from query string
$menu_item_id = $_GET['id'] ?? null;

if (!$menu_item_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing menu item ID']);
    exit;
}

try {
    // Optional: you could check for ownership of the menu item here if needed

    $stmt = $pdo->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->execute([$menu_item_id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Menu item deleted']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Menu item not found']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
