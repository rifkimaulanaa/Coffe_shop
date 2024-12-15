<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit User</title>
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

                        $user_id = isset($_GET['id']) ? $_GET['id'] : '';
                        $user_data = null;

                        // Ambil data user berdasarkan ID
                        if (!empty($user_id)) {
                            $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
                            $stmt->bind_param('i', $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $user_data = $result->fetch_assoc();
                            $stmt->close();
                        }

                        if (!$user_data) {
                            echo "<script>alert('User tidak ditemukan!'); window.location.href='user_list.php';</script>";
                            exit;
                        }

                        if (isset($_POST['submit'])) {
                            $username = trim($_POST['username']);
                            $email = trim($_POST['email']);
                            $role = trim($_POST['role']);
                            $password = trim($_POST['password']);

                            // Validasi input
                            if (empty($username) || empty($email) || empty($role)) {
                                echo "<script>alert('Username, Email, dan Role wajib diisi!');</script>";
                            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                echo "<script>alert('Email tidak valid!');</script>";
                            } else {
                                $update_query = "UPDATE users SET username = ?, email = ?, role = ?";

                                // Tambahkan password ke query jika diisi
                                if (!empty($password)) {
                                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                                    $update_query .= ", password = '$hashed_password'";
                                }

                                $update_query .= " WHERE id = ?";

                                $stmt = $conn->prepare($update_query);
                                $stmt->bind_param('sssi', $username, $email, $role, $user_id);

                                if ($stmt->execute()) {
                                    echo "<script>alert('Data berhasil diperbarui!'); window.location.href='user_list.php';</script>";
                                } else {
                                    echo "<script>alert('Data gagal diperbarui: " . $stmt->error . "');</script>";
                                }

                                $stmt->close();
                            }
                        }

                        mysqli_close($conn);
                    ?>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">USERNAME</label>
                            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">EMAIL</label>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">ROLE</label>
                            <select class="form-control" name="role" required>
                                <option value="admin" <?php echo ($user_data['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="editor" <?php echo ($user_data['role'] == 'manajer') ? 'selected' : ''; ?>>Editor</option>
                                <option value="viewer" <?php echo ($user_data['role'] == 'karyawan') ? 'selected' : ''; ?>>Viewer</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">PASSWORD</label>
                            <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
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
</body>
</html>
