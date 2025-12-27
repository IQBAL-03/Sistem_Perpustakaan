<?php
session_start();
if (isset($_SESSION['id'])) {
    header("Location: ../barang/index.php");
    exit();
}
require_once '../config/koneksi.php';
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Username dan Password tidak boleh kosong";
    } else {
        $sql = "SELECT * FROM pengguna WHERE username = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: /sistem-perpus/index.php?status=login_sukses");
                exit();
            } else {
                $error = "Password salah !";
            }
        } else {
            $error = "Username Tidak Ditemukan";
        }

        mysqli_stmt_close($stmt);
    }
}
$judul = "Login";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= $judul ?> - Sistem Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            min-height: 100vh;
        }

        .login-card {
            border-radius: 15px;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow login-card">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="bi bi-book-half fs-1 text-primary"></i>
                            <h4 class="mt-2">Sistem Perpustakaan</h4>
                            <p class="text-muted">Silakan login</p>
                        </div>
                        <?php
                        if (isset($_GET['status']) && $_GET['status'] == 'logout_sukses'){
                            echo '<div class="alert alert-succes">Anda berhasil logout.</div>';
                        }

                        if (isset($_GET['pesan']) && $_GET['pesan'] == 'belum_login'){
                            echo '<div class="alert alert-warning">Anda harus login terlebih dahulu.</div>';
                        }
                        ?>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="username"
                                       name="username"
                                       placeholder="Masukkan username"
                                       value="<?= isset($username) ? htmlspecialchars($username) : '' ?>"
                                       required
                                       autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" 
                                       class="form-control"
                                       id="password"
                                       name="password" 
                                       placeholder="Masukkan password"
                                       required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                © 2025 Perpustakaan Digital
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
mysqli_close($koneksi);
?>