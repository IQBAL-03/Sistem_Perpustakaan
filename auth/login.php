<?php
session_start();
if (isset($_SESSION['id'])) {
    header("Location: ../buku/index.php");
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

                header("Location: ../dashboard/index.php?status=login_sukses");
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
    <link rel="icon" type="image/x-icon" href="../image/icon.png">
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

    <div id="loader" class="position-fixed vh-100 vw-100 d-flex justify-content-center align-items-center bg-white"
        style="z-index: 9999; top: 0; left: 0;">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <div class="card shadow-lg border-0 login-card">

                    <div class="card-body p-4">

                        <div class="text-center mb-4">
                            <i class="bi bi-book-half fs-1 text-primary"></i>
                            <h4 class="mt-2 fw-bold">Sistem Perpustakaan</h4>
                            <p class="text-muted mb-0">Silakan login untuk melanjutkan</p>
                        </div>

                        <?php
                        if (isset($_GET['status']) && $_GET['status'] == 'logout_sukses') {
                            echo '<div class="alert alert-warning">Anda berhasil logout.</div>';
                        }

                        if (isset($_GET['pesan']) && $_GET['pesan'] == 'belum_login') {
                            echo '<div class="alert alert-warning">Anda harus login terlebih dahulu.</div>';
                        }
                        ?>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger text-center">
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Masukkan password" required>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer text-center text-muted">
                        <a href="../index.php" class="text-decoration-none">
                            <i class="bi bi-house-door"></i> Kembali ke Beranda
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</body>
<script src="../js/script.js"></script>
</html>

<?php
mysqli_close($koneksi);
?>
