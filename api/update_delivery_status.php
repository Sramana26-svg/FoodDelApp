<?php
header('Content-Type: application/json');
require_once '../config.php';

$assignment_id = $_GET['assignment_id'] ?? null;

if (!$assignment_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing assignment_id']);
    exit;
}

$stmt = $pdo->prepare("UPDATE delivery_assignments SET delivered_time = NOW() WHERE id = ?");
$stmt->execute([$assignment_id]);

echo json_encode(['success' => true, 'message' => 'Delivery marked complete']);
