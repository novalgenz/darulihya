<?php
// ============================================================
//  KONFIGURASI DATABASE — Sesuaikan dengan data hosting kamu
// ============================================================
define('DB_HOST', 'sql200.infinityfree.com'); // cek di panel InfinityFree
define('DB_NAME', 'epiz_XXXXXXX_mis');         // nama database
define('DB_USER', 'epiz_XXXXXXX');             // username MySQL
define('DB_PASS', 'password_kamu');             // password MySQL

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
