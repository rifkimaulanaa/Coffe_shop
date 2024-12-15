<?php
// Sertakan file koneksi database
require_once("proses.php");

// Periksa apakah request menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input: Ambil 'id' dari POST dan pastikan itu integer
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']);

        // Jika ID valid
        if ($id > 0) {
            try {
                // Gunakan Prepared Statement untuk mencegah SQL Injection
                $stmt = $mysqli->prepare("DELETE FROM menu WHERE id = ?");
                $stmt->bind_param("i", $id); // 'i' berarti tipe data integer

                // Eksekusi query
                if (!$stmt->execute()) {
                    throw new Exception("Gagal menghapus data: " . $stmt->error);
                }

                // Tutup statement
                $stmt->close();

                // Jika berhasil, redirect ke halaman utama
                header("Location: http://localhost/coffe_shop/dashboard/pages/add.php");
                exit();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            echo "ID tidak valid.";
        }
    } else {
        echo "Parameter ID tidak ditemukan.";
    }
} else {
    echo "Permintaan tidak sah.";
}
?>

