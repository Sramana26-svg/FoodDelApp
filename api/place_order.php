<?php
header('Content-Type: application/json');
require_once '../config.php';

$data = json_decode(file_get_contents('php://input'), true);

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO orders (customer_id, restaurant_id, total_amount) VALUES (?, ?, ?)");
    $stmt->execute([$data['customer_id'], $data['restaurant_id'], $data['total_amount']]);
    $order_id = $pdo->lastInsertId();

    $item_stmt = $pdo->prepare("INSERT INTO order_items (order_id, menu_item_id, quantity, price_each) VALUES (?, ?, ?, ?)");

    foreach ($data['items'] as $item) {
        $item_stmt->execute([$order_id, $item['menu_item_id'], $item['quantity'], $item['price_each']]);
    }

    $pdo->commit();
    echo json_encode(['success' => true, 'order_id' => $order_id]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
