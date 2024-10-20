<?php
// Database credentials
$host = 'host.docker.internal';
$port = '3306';
$db   = 'course_catalog';
$user = 'test_user';
$pass = 'test_password';

$dsn = "mysql:host=$host;port=$port;dbname=$db;";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // return associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,  // use native prepared statements
];

try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Handle connection error
    echo "Connection failed: " . $e->getMessage();
}
