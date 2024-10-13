<?php
session_start(); // Memulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_nama'])) {
    header("Location: LogIn.php");
    exit();
}

// Koneksi ke database
require 'dbh.php'; // Pastikan ini sudah terhubung ke dbconnect.php

// Query untuk mengambil data dari RESEP
$sql = "SELECT NAMA_MAKANAN, ASAL_NEGARA, BAHAN_UTAMA, LINK_TUTORIAL, GAMBAR_MAKANAN FROM RESEP";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Resep</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .food-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
            display: flex;
            align-items: center;
        }
        .food-item img {
            margin-right: 20px;
            max-width: 200px;
            height: auto;
        }
        .no-data {
            margin: 20px 0;
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>
    <h1>List Resep</h1>
    <form action="Home.php">
        <input type="submit" value="Kembali ke Home">
    </form>
    <br>
    <form action="LogOut.php">
        <input type="submit" value="Log Out">
    </form>
    <br>
    <form action="InputList.php">
        <input type="submit" value="Tambah Resep">
    </form>
    
    <?php
    if ($result && $result->rowCount() > 0) { // Check if there are results
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='food-item'>";
            $image_path = 'gambar/' . htmlspecialchars($row["GAMBAR_MAKANAN"]);
            echo "<img src='" . $image_path . "' alt='" . htmlspecialchars($row["NAMA_MAKANAN"]) . "'>";
            echo "<div>";
            echo "<h2>" . htmlspecialchars($row["NAMA_MAKANAN"]) . "</h2>";
            echo "<p>Asal Negara: " . htmlspecialchars($row["ASAL_NEGARA"]) . "</p>";
            echo "<p>Bahan Utama: " . htmlspecialchars($row["BAHAN_UTAMA"]) . "</p>";
            echo "<p>Link Tutorial: <a href='" . htmlspecialchars($row["LINK_TUTORIAL"]) . "'>Tutorial</a></p>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        // If no data is found
        echo "<p class='no-data'>Belum ada data di database.</p>";
    }
    
    $pdo = null; // Close the database connection
    ?>
</body>
</html>
