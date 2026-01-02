<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';
$judul = "Edit Pengguna";

if (!isset($_GET['id'])) {
    header("Location: kelola_pengguna.php");
    exit;
}

$id = (int)$_GET['id'];

$sql = "SELECT * FROM pengguna WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pengguna = mysqli_fetch_assoc($result);

if (!$pengguna) {
    header("Location: kelola_pengguna.php");
    exit;
}

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $role = trim($_POST['role']);

    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong";
    }

    if (empty($username)) {
        $errors[] = "Username tidak boleh kosong";
    }

    if (!in_array($role, ['admin','staff','member'])) {
        $errors[] = "Role tidak valid";
    }


    if (empty($errors)) {
        $sql_update = "UPDATE pengguna SET nama = ?, username = ?, role = ? WHERE id = ?";
        $stmt_update = mysqli_prepare($koneksi, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "sssi", $nama, $username, $role, $id);
        if (mysqli_stmt_execute($stmt_update)) {
            $success = true;
            $pengguna['nama'] = $nama;
            $pengguna['username'] = $username;
            $pengguna['role'] = $role;
        } else {
            $errors[] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        }
        mysqli_stmt_close($stmt_update);
    }
}

require_once '../partials/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Pengguna</h5>
                </div>
                <div class="card-body">

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> Data pengguna berhasil diupdate.
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" id="nama" name="nama" class="form-control" value="<?= htmlspecialchars($pengguna['nama']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($pengguna['username']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" name="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" <?= $pengguna['role']=='admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="staff" <?= $pengguna['role']=='staff' ? 'selected' : '' ?>>Staff</option>
                                <option value="member" <?= $pengguna['role']=='member' ? 'selected' : '' ?>>Member</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-warning"><i class="bi bi-check-circle"></i> Simpan Perubahan</button>
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
