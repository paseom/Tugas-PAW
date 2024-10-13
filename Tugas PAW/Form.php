<?php
// Cek apakah form sudah dikirimkan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Simpan data pengguna ke dalam sesi (atau bisa disimpan ke database)
    $_SESSION['user_nama'] = $nama;
    $_SESSION['user_pass'] = $password; // Simpan password sesuai input

    try {
        require_once "dbh.php";

        // Cek apakah email sudah ada
        $query_check = "SELECT * FROM pengguna WHERE email = :email";
        $stmt_check = $pdo->prepare($query_check);
        $stmt_check->bindParam(":email", $email);
        $stmt_check->execute();

        // Jika email sudah ada, tampilkan pesan kesalahan
        if ($stmt_check->rowCount() > 0) {
            echo "<p>Akun anda sudah terdaftar sebelumnya!</p>";
            echo '<form action="LogIn.php" method="get">
                    <input type="submit" value="Log In">
                </form>';
        } else {
            // Jika email belum ada, lanjutkan dengan insert
            $query_pengguna = "INSERT INTO pengguna (NAMA, EMAIL, PASSWORD) VALUES (:nama, :email, :password);";

            $stmt = $pdo->prepare($query_pengguna);

            $stmt->bindParam(":nama", $nama);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);

            $stmt->execute();

            // Redirect ke halaman Log In setelah berhasil mendaftar
            header("Location: LogIn.php");
            exit();
        }

        $pdo = null;
        $stmt = null;

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
?>
