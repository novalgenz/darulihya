<?php
// ============================================================
//  KONFIGURASI DATABASE
//  Ganti sesuai data MySQL di panel InfinityFree kamu
//  Panel → MySQL Databases → lihat username & nama DB
// ============================================================
define('DB_HOST', 'sql200.infinityfree.com'); // host dari panel
define('DB_NAME', 'if0_41879933_mis');        // nama database
define('DB_USER', 'if0_41879933');            // username MySQL
define('DB_PASS', 'Mei10052026');            // password MySQL

try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER, DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );
} catch (PDOException $e) {
    die(json_encode(['error' => 'Koneksi DB gagal: ' . $e->getMessage()]));
}
