<?php
header('Content-Type: application/json');
require_once '../config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['name'], $data['email'], $data['password'], $data['role'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing fields']);
    exit;
}

$hash = password_hash($data['password'], PASSWORD_BCRYPT);

$stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
$stmt->execute([$data['name'], $data['email'], $hash, $data['role']]);

echo json_encode(['success' => true, 'message' => 'User registered']);
