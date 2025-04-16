<?php
header('Content-Type: application/json');
require_once '../config.php';

try {
    $stmt = $pdo->query("SELECT * FROM restaurants");
    $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($restaurants);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>    
