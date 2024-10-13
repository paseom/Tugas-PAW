<?php
require 'dbh.php'; // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_makanan = $_POST['nama_makanan'];
    $asal_negara = $_POST['asal_negara'];
    $bahan_utama = $_POST['bahan_utama'];
    $link_tutorial = $_POST['link_tutorial'];
    $gambar_makanan = $_FILES['gambar']['name'];

    $upload_dir = 'gambar/';
    $upload_file = $upload_dir . basename($gambar_makanan);

    try {
        // Pindahkan file gambar ke direktori yang dituju
        move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_file);

        // Query untuk memasukkan data ke tabel RESEP
        $query_resep = "INSERT INTO RESEP (NAMA_MAKANAN, ASAL_NEGARA, BAHAN_UTAMA, LINK_TUTORIAL, GAMBAR_MAKANAN) 
                        VALUES (:nama_makanan, :asal_negara, :bahan_utama, :link_tutorial, :gambar_makanan)";
        
        $stmt = $pdo->prepare($query_resep);
        
        // Binding parameters
        $stmt->bindParam(":nama_makanan", $nama_makanan);
        $stmt->bindParam(":asal_negara", $asal_negara);
        $stmt->bindParam(":bahan_utama", $bahan_utama);
        $stmt->bindParam(":link_tutorial", $link_tutorial);
        $stmt->bindParam(":gambar_makanan", $gambar_makanan);
        
        // Execute the query
        $stmt->execute();

        // Redirect after successful insertion
        header("Location: List.php");
        exit();
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Integrity constraint violation
            // Redirect to the list page if a duplicate entry occurs
            echo"Data sudah ada!";
            header("Location: List.php");
            exit();
        } else {
            die("Query failed: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input List</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        Nama Makanan: <br><input type="text" name="nama_makanan" required><br><br>
        Asal Negara: <br><input type="text" name="asal_negara" required><br><br>
        Bahan Utama: <br><input type="text" name="bahan_utama" required><br><br>
        Link Tutorial: <br><input type="link" name="link_tutorial" required><br><br>
        Gambar: <input type="file" name="gambar" required><br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>

