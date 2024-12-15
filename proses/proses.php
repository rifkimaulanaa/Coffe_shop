<?php

// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kafetaria";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}



// Cek apakah form register telah dikirimkan
if (isset($_POST['register'])) {
    // Ambil data dari formulir register
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $passwordInput = $_POST['password'] ?? '';

    // Validasi input
    if (empty($nama) || empty($email) || empty($passwordInput)) {
        echo "Semua kolom harus diisi.";
        exit;
    }

    // Query untuk register
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nama, $email, $passwordInput);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>
                  alert('Register Berhasil');
                  window.location.href = '../pages/sign-in.php';
              </script>";
        exit;
    } else {
        echo "<script>
                  alert('Gagal menambahkan data.');
                  window.history.back();
              </script>";
    }

    // $stmt->close();
}

// $conn->close(); // Tutup koneksi