<?php
$server = 'localhost';
$user   = 'root';
$pass   = '';
$dbname = 'wanderlust';

try {
    $dsn = "mysql:host=$server;charset=utf8mb4";
    $conn = new PDO($dsn, $user, $pass);

    
    $sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
    $conn->exec($sql);

    $conn->exec("USE `$dbname`");


    // Hotel table
    $table = "CREATE TABLE IF NOT EXISTS hotel (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(150) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        description TEXT,
        location VARCHAR(150) NOT NULL,
        country VARCHAR(160) NOT NULL,
        image_url TEXT
    )";
    $conn->exec($table);
   

    // User table
    $signup = "CREATE TABLE IF NOT EXISTS users (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(170) NOT NULL,
        email VARCHAR(190) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin','user') NOT NULL DEFAULT 'user',
        country VARCHAR(120) NOT NULL,
        image_url TEXT,
        status TINYINT(1) NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($signup);
    

    // Cookies table
    $cookie = "CREATE TABLE IF NOT EXISTS cookies (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        token VARCHAR(255) NOT NULL,
        expires_at DATETIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($cookie);

} catch (PDOException $e) {
   
    logError("Database Create Error: " . $e->getMessage());
    die("Something went wrong Please try again later.");
}
?>
