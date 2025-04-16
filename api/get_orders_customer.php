<?php
header('Content-Type: application/json');
require_once '../config.php';

$customer_id = $_GET['cid'] ?? null;

if (!$customer_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing customer_id']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM orders WHERE customer_id = ?");
$stmt->execute([$customer_id]);
echo json_encode($stmt->fetchAll());
