<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Menu</title>
    <link rel="icon" href="../../image/about-icon-2.png" type="image/x-icon" />
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

                        $menu_id = isset($_GET['id']) ? $_GET['id'] : '';
                        $menu_data = null;

                        // Ambil data menu berdasarkan ID
                        if (!empty($menu_id)) {
                            $stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
                            $stmt->bind_param('i', $menu_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $menu_data = $result->fetch_assoc();
                            $stmt->close();
                        }

                        if (!$menu_data) {
                            echo "<script>alert('Menu tidak ditemukan!'); window.location.href='menu_list.php';</script>";
                            exit;
                        }

                        if (isset($_POST['submit'])) {
                            $image = $_FILES['image']['name'];
                            $title = trim($_POST['title']);
                            $description = trim($_POST['description']);
                            $price = trim($_POST['price']);
                            $stock = trim($_POST['stock']);

                            // Validasi input
                            if (empty($title) || empty($description) || empty($price) || empty($stock)) {
                                echo "<script>alert('Semua field wajib diisi!');</script>";
                            } elseif (!is_numeric($price) || !is_numeric($stock)) {
                                echo "<script>alert('Harga dan Stok harus berupa angka!');</script>";
                            } elseif (!empty($image) && $_FILES['image']['size'] > 2000000) {
                                echo "<script>alert('Ukuran file tidak boleh lebih dari 2MB!');</script>";
                            } else {
                                // Validasi file upload jika ada file baru
                                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                                $file_extension = pathinfo($image, PATHINFO_EXTENSION);

                                if (!empty($image) && !in_array(strtolower($file_extension), $allowed_extensions)) {
                                    echo "<script>alert('Format file tidak didukung! Hanya JPG, JPEG, PNG, GIF.');</script>";
                                } else {
                                    $update_query = "UPDATE menu SET name = ?, description = ?, price = ?, stock = ?";

                                    // Jika ada file gambar baru, tambahkan ke query
                                    if (!empty($image)) {
                                        $new_image_name = "menu-$menu_id.$file_extension";
                                        $upload_path = "../../image/" . $new_image_name;
                                        move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
                                        $update_query .= ", image = '$new_image_name'";
                                    }

                                    $update_query .= " WHERE id = ?";

                                    $stmt = $conn->prepare($update_query);
                                    $stmt->bind_param('ssiii', $title, $description, $price, $stock, $menu_id);

                                    if ($stmt->execute()) {
                                        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='add.php';</script>";
                                    } else {
                                        echo "<script>alert('Data gagal diperbarui: " . $stmt->error . "');</script>";
                                    }

                                    $stmt->close();
                                }
                            }
                        }

                        mysqli_close($conn);
                    ?>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">IMAGE</label>
                            <input type="file" class="form-control" name="image">
                            <?php if (!empty($menu_data['image'])): ?>
                                <img src="../../image/<?php echo $menu_data['image']; ?>" alt="Menu Image" class="img-thumbnail mt-2" width="150">
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">TITLE</label>
                            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($menu_data['name']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">DESCRIPTION</label>
                            <textarea class="form-control" name="description" rows="5" required><?php echo htmlspecialchars($menu_data['description']); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">PRICE</label>
                                    <input type="number" class="form-control" name="price" value="<?php echo htmlspecialchars($menu_data['price']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">STOCK</label>
                                    <input type="number" class="form-control" name="stock" value="<?php echo htmlspecialchars($menu_data['stock']); ?>" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-md btn-primary me-3">UPDATE</button>
                        <a href="add.php" class="btn btn-md btn-secondary">CANCEL</a>
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
