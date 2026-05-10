<?php
/**
 * DATABASE CONFIGURATION
 * Automatically detects if running on localhost or production (InfinityFree)
 */

$is_local = in_array($_SERVER['SERVER_NAME'] ?? '', ['localhost', '127.0.0.1']) || (isset($_SERVER['SERVER_NAME']) && strpos($_SERVER['SERVER_NAME'], '.test') !== false);

if ($is_local) {
    // Local (Laragon) Settings
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'db_darul_ihya'); // Ensure this matches your local DB name
    define('DB_USER', 'root');
    define('DB_PASS', '');
} else {
    // Production (InfinityFree) Settings
    define('DB_HOST', 'sql200.infinityfree.com');
    define('DB_NAME', 'if0_41879933_mis');
    define('DB_USER', 'if0_41879933');
    define('DB_PASS', 'Mei10052026');
}

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    die(json_encode([
        'ok'    => false,
        'error' => 'Koneksi Database Gagal: ' . $e->getMessage()
    ]));
}

