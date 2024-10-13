<?php
// $host = 'localhost';
// $dbname = 'COOKBOOK';
// $user = 'root';
// $password = '';
$dsn = "mysql:host=localhost;dbname=cookbook";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Jika koneksi gagal, tampilkan pesan error
    echo "Koneksi gagal: " . $e->getMessage();
}
?>
