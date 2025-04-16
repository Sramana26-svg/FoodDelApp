<?php
header('Content-Type: application/json');
require_once '../config.php';

$stmt = $pdo->query("SELECT * FROM restaurants");
echo json_encode($stmt->fetchAll());
