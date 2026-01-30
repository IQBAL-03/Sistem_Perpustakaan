<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';
$judul = "Tambah Pengguna";

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    $errors = [];
    $success = false;

    if (empty($nama))
        $errors[] = "Nama tidak boleh kosong";
    if (empty($username))
        $errors[] = "Username tidak boleh kosong";
    if (empty($password))
        $errors[] = "Password tidak boleh kosong";
    if ($password !== $confirm_password)
        $errors[] = "Password dan konfirmasi tidak cocok";

    if (empty($errors)) {
        $sql_check = "SELECT id FROM pengguna WHERE username = ?";
        $stmt_check = mysqli_prepare($koneksi, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $username);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $errors[] = "Username sudah digunakan";
        }
        mysqli_stmt_close($stmt_check);
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        // Set foto kosong by default sesuai keinginan user
        // Set foto kosong by default sesuai keinginan user
        $sql_insert = "INSERT INTO pengguna (nama, username, password, role, tanggal_dibuat, foto) VALUES (?, ?, ?, 'staff', NOW(), '')";
        $stmt_insert = mysqli_prepare($koneksi, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, "sss", $nama, $username, $hashed_password);

        if (mysqli_stmt_execute($stmt_insert)) {
            $success = true;
            $nama = $username = $password = $confirm_password = "";
        } else {
            $errors[] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        }

        mysqli_stmt_close($stmt_insert);
    }
}

require_once '../partials/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-plus"></i> Tambah Pengguna Baru</h5>
                </div>
                <div class="card-body">

                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> Pengguna baru berhasil ditambahkan.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" class="form-control"
                                value="<?= htmlspecialchars($nama ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control"
                                value="<?= htmlspecialchars($username ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                                required>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Tambah
                                Pengguna</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
mysqli_close($koneksi);
require_once '../partials/footer.php';
?>