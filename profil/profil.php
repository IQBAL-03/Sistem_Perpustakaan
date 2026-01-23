<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';

$id_user = $_SESSION['user_id'];
$pesan_sukses = "";
$pesan_error = "";

if (isset($_POST['update_profil'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $foto_baru = "";

    if ($_FILES['foto']['error'] === 4) {
        $pesan_error = "Silahkan upload foto terlebih dahulu!";
    } elseif ($_FILES['foto']['error'] === 0) {
        $nama_file = $_FILES['foto']['name'];
        $ukuran_file = $_FILES['foto']['size'];
        $tmp_name = $_FILES['foto']['tmp_name'];

        $ekstensi_valid = ['jpg', 'jpeg', 'png', 'webp'];
        $ekstensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        if (!in_array($ekstensi_file, $ekstensi_valid)) {
            $pesan_error = "Hanya file JPG, JPEG, PNG, dan WEBP yang diperbolehkan!";
        } elseif ($ukuran_file > 26214400) {
            $pesan_error = "Ukuran file terlalu besar! Maksimal 25MB.";
        } else {
            $foto_baru = uniqid() . '.' . $ekstensi_file;
            $tujuan = '../uploads/' . $foto_baru;

            if (move_uploaded_file($tmp_name, $tujuan)) {
                $sql_lama = "SELECT foto FROM pengguna WHERE id = '$id_user'";
                $res_lama = mysqli_query($koneksi, $sql_lama);
                $old_data = mysqli_fetch_assoc($res_lama);
                if (!empty($old_data['foto']) && file_exists('../uploads/' . $old_data['foto'])) {
                    unlink('../uploads/' . $old_data['foto']);
                }
            } else {
                $pesan_error = "Gagal mengupload foto.";
            }
        }
    }

    if (empty($pesan_error)) {
        if (!empty($foto_baru)) {
            $sql = "UPDATE pengguna SET nama = '$nama', username = '$username', foto = '$foto_baru' WHERE id = '$id_user'";
        } else {
            $sql = "UPDATE pengguna SET nama = '$nama', username = '$username' WHERE id = '$id_user'";
        }

        if (mysqli_query($koneksi, $sql)) {
            $_SESSION['nama'] = $nama;
            $_SESSION['username'] = $username;
            if (!empty($foto_baru)) {
                $_SESSION['foto'] = $foto_baru;
            }
            $pesan_sukses = "Profil berhasil diperbarui!";
        } else {
            $pesan_error = "Gagal memperbarui profil: " . mysqli_error($koneksi);
        }
    }
}

if (isset($_POST['hapus_foto'])) {
    $sql = "SELECT foto FROM pengguna WHERE id = '$id_user'";
    $res = mysqli_query($koneksi, $sql);
    $data = mysqli_fetch_assoc($res);

    if (!empty($data['foto'])) {
        if (file_exists('../uploads/' . $data['foto'])) {
            unlink('../uploads/' . $data['foto']);
        }
        $sql_upd = "UPDATE pengguna SET foto = '' WHERE id = '$id_user'";
        if (mysqli_query($koneksi, $sql_upd)) {
            $_SESSION['foto'] = '';
            $pesan_sukses = "Foto profil berhasil dihapus!";
        }
    }
}

if (isset($_POST['ganti_password'])) {
    $pw_lama = $_POST['password_lama'];
    $pw_baru = $_POST['password_baru'];
    $konfirmasi = $_POST['konfirmasi_password'];

    $sql = "SELECT password FROM pengguna WHERE id = '$id_user'";
    $res = mysqli_query($koneksi, $sql);
    $user = mysqli_fetch_assoc($res);

    if (password_verify($pw_lama, $user['password'])) {
        if ($pw_baru === $konfirmasi) {
            $hashed_pw = password_hash($pw_baru, PASSWORD_DEFAULT);
            $sql_upd = "UPDATE pengguna SET password = '$hashed_pw' WHERE id = '$id_user'";
            if (mysqli_query($koneksi, $sql_upd)) {
                $pesan_sukses = "Password berhasil diganti!";
            } else {
                $pesan_error = "Gagal mengganti password.";
            }
        } else {
            $pesan_error = "Konfirmasi password tidak cocok!";
        }
    } else {
        $pesan_error = "Password lama salah!";
    }
}

$judul = "Pengaturan Akun";
require_once '../partials/header.php';
?>
<div class="container my-5" style="max-width: 1000px;">
    <h3 class="fw-bold mb-4">
        <i class="bi bi-gear-fill"></i> Pengaturan Akun
    </h3>

    <?php if (!empty($pesan_sukses)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> <?= $pesan_sukses ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($pesan_error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> <?= $pesan_error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-person-fill"></i> Informasi Akun
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control"
                               value="<?= htmlspecialchars($_SESSION['nama'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control"
                               value="<?= htmlspecialchars($_SESSION['username'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Foto Profil</label>
                        <input type="file" name="foto" class="form-control" accept=".png, .jpg, .jpeg, .webp">
                        <small class="text-muted">Upload file foto max 25mb</small>
                    </div>
                    <div class="col-md-6 d-flex align-items-end mt-3 mt-md-0">
                        <?php if (!empty($_SESSION['foto'])): ?>
                            <div class="text-center">
                                <img src="../uploads/<?= $_SESSION['foto']; ?>"
                                     class="rounded border shadow-sm mb-2"
                                     width="120" height="120"
                                     style="object-fit: cover;">
                                <br>
                                <button type="submit" name="hapus_foto" class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus foto profil?')">
                                    <i class="bi bi-trash"></i> Hapus Foto
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="rounded border border-secondary border-dashed d-flex flex-column align-items-center justify-content-center bg-light shadow-sm"
                                 style="width: 120px; height: 120px; border-style: dashed !important;">
                                <i class="bi bi-camera text-muted fs-2"></i>
                                <small class="text-muted mt-1" style="font-size: 0.7rem;">Foto Profil</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <button type="submit" name="update_profil" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-warning">
            <i class="bi bi-shield-lock-fill"></i> Ganti Password
        </div>
        <div class="card-body">
            <form method="post">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Password Lama</label>
                        <input type="password" name="password_lama" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password_baru" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_password" class="form-control" required>
                    </div>
                </div>
                <button type="submit" name="ganti_password" class="btn btn-warning">
                    <i class="bi bi-key-fill"></i> Ganti Password
                </button>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <a href="../dashboard/index.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
        <a href="../auth/logout.php" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
            <i class="bi bi-box-arrow-right"></i> Keluar / Logout
        </a>
    </div>
</div>
<?php
mysqli_close($koneksi);
require_once '../partials/footer.php';
?>
