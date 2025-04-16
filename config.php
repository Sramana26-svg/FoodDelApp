<?php
// config.php
$host    = '127.0.0.1';        // or 'localhost'
$db      = 'FoodDelApp';
$user    = 'root';             // or your MySQL user
$pass    = 'Bahubali1234#';                 
$charset = 'utf8mb4';

// If you changed the port to 3307, include it here:
$port    = '3307';             // set to '' if still 3306

$dsn = "mysql:host=$host" 
     . ($port ? ";port=$port" : "")
     . ";dbname=$db;charset=$charset";

$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
  http_response_code(500);
  exit('DB Connection failed: '.$e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
