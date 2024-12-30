<?php
// Konfigurasi database
$host = 'localhost'; // Host database
$db   = 'universitas_hulondalo'; // Nama database
$user = 'root'; // Username database
$pass = ''; // Password database
$charset = 'utf8mb4'; // Charset database

// Opsi PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Aktifkan mode error exception
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Set fetch mode ke associative array
    PDO::ATTR_EMULATE_PREPARES   => false, // Nonaktifkan emulasi prepared statements
];

// Buat DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    // Buat koneksi PDO
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Tangani error jika koneksi gagal
    die("Koneksi database gagal: " . $e->getMessage());
}

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>