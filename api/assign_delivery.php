<?php
header('Content-Type: application/json');
require_once '../config.php';

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($data['order_id'], $data['agent_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing order_id or agent_id']);
    exit;
}

try {
    // Check if order already has a delivery assigned
    $check = $pdo->prepare("SELECT id FROM delivery_assignments WHERE order_id = ?");
    $check->execute([$data['order_id']]);
    if ($check->rowCount() > 0) {
        echo json_encode(['success' => false, 'error' => 'Delivery already assigned']);
        exit;
    }

    // Insert delivery assignment
    $stmt = $pdo->prepare("INSERT INTO delivery_assignments (order_id, agent_id) VALUES (?, ?)");
    $stmt->execute([$data['order_id'], $data['agent_id']]);

    echo json_encode(['success' => true, 'message' => 'Delivery agent assigned']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
