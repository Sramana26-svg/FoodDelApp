<?php
header('Content-Type: application/json');
require_once '../config.php';

$restaurant_id = $_GET['restaurant_id'] ?? null;

if (!$restaurant_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing restaurant_id']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM orders WHERE restaurant_id = ?");
$stmt->execute([$restaurant_id]);
echo json_encode($stmt->fetchAll());
