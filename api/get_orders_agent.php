<?php
header('Content-Type: application/json');
require_once '../config.php';

$agent_id = $_GET['agent_id'] ?? null;

if (!$agent_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing agent_id']);
    exit;
}

$stmt = $pdo->prepare("
    SELECT da.id AS assignment_id, o.*, r.name AS restaurant_name
    FROM delivery_assignments da
    JOIN orders o ON da.order_id = o.id
    JOIN restaurants r ON o.restaurant_id = r.id
    WHERE da.agent_id = ?
");
$stmt->execute([$agent_id]);
echo json_encode($stmt->fetchAll());
