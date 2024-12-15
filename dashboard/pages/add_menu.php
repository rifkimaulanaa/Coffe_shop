<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Data</title>
    <link rel="icon" href="../../image/about-icon-2.png"
        type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background: lightgray">

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                    <?php
            include_once "../../proses/proses.php";

            if (isset($_POST['submit'])) {
                $image = $_FILES['image']['name'];
                $title = trim($_POST['title']);
                $description = trim($_POST['description']);
                $price = trim($_POST['price']);
                $stock = trim($_POST['stock']);

                // Validasi input
                if (empty($image) || empty($title) || empty($description) || empty($price) || empty($stock)) {
                    echo "<script>alert('Semua field wajib diisi!');</script>";
                } elseif (!is_numeric($price) || !is_numeric($stock)) {
                    echo "<script>alert('Harga dan Stok harus berupa angka!');</script>";
                } elseif ($_FILES['image']['size'] > 2000000) {
                    echo "<script>alert('Ukuran file tidak boleh lebih dari 2MB!');</script>";
                } else {
                    // Validasi file upload
                    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                    $file_extension = pathinfo($image, PATHINFO_EXTENSION);
                    if (!in_array(strtolower($file_extension), $allowed_extensions)) {
                        echo "<script>alert('Format file tidak didukung! Hanya JPG, JPEG, PNG, GIF.');</script>";
                    } else {
                        // Masukkan data ke database tanpa nama file
                        $stmt = $conn->prepare("INSERT INTO menu (name, description, price, stock) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param('ssii', $title, $description, $price, $stock);

            if ($stmt->execute()) {
                // Dapatkan ID dari data yang baru saja dimasukkan
                $last_id = $conn->insert_id;

                // Tentukan nama file baru
                $new_image_name = "menu-$last_id.$file_extension";

                // Path folder tujuan
                $upload_path = "../../image/" . $new_image_name;

                // Pindahkan file yang diunggah
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    // Perbarui kolom 'image' dengan nama file baru
                    $update_stmt = $conn->prepare("UPDATE menu SET image = ? WHERE id = ?");
                    $update_stmt->bind_param('si', $new_image_name, $last_id);

                    if ($update_stmt->execute()) {
                        echo "<script>alert('Data Berhasil di Inputkan'); window.location.href='add.php';</script>";
                    } else {
                        echo "<script>alert('Data Gagal diupdate: " . $update_stmt->error . "');</script>";
                    }

                    $update_stmt->close();
                } else {
                    echo "<script>alert('Gagal mengunggah file!');</script>";
                }
            } else {
                echo "<script>alert('Data Gagal di Inputkan: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        }
    }

    mysqli_close($conn);
}
?>


                        <div class="form-group mb-3">
                            <label class="font-weight-bold">IMAGE</label>
                            <input type="file" class="form-control" name="image" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">TITLE</label>
                            <input type="text" class="form-control" name="title" placeholder="Masukkan Judul" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">DESCRIPTION</label>
                            <textarea class="form-control" name="description" rows="5" placeholder="Masukkan Deskripsi" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">PRICE</label>
                                    <input type="number" class="form-control" name="price" placeholder="Masukkan Harga" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">STOCK</label>
                                    <input type="number" class="form-control" name="stock" placeholder="Masukkan Stok" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-md btn-primary me-3">SUBMIT</button>
                        <button type="reset" class="btn btn-md btn-warning">RESET</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>
</body>
</html>
