<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';
$judul = "Pengembalian";

$errors = [];
$success = false;
$jumlah_sukses = 0;
$nama_buku_sukses = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul_buku = trim($_POST["judul_buku"]);
    $nama_pengguna = trim($_POST['nama_pengguna']);
    $tanggal_pinjam = trim($_POST['tanggal-pinjam']);
    $tanggal_dikembalikan = trim($_POST['tanggal_dikembalikan']);
    $keterlambatan = trim($_POST['keterlambatan']);
    $denda = trim($_POST['denda']);
    $status_pengembalian = trim($_POST['status_pengembalian']);

    if (empty($judul_buku)) {
        $errors[] = "Judul Buku Tidak Boleh Kosong";
    }

    if (empty($nama_pengguna)) {
        $errors[] = "Nama Peminjam Tidak Boleh Kosong";
    }

    if (empty($tanggal_pinjam)) {
        $errors[] = "Tanggal Pinjam Tidak Boleh Kosong";
    }

    if (empty($tanggal_dikembalikan)) {
        $errors[] = "Tanggal Kembali Tidak Boleh Kosong";
    }

    if(empty($keterlambatan)){
        $errors[] = "Keterlambatan Tidak Boleh Kosong";
    }

    if (isset($_POST['denda']) && $_POST['denda'] !== '') {
        $denda = (int) $_POST['denda'];

        if ($denda < 0) {
            $errors[] = "Denda Tidak Boleh Kurang Dari 0";
        }
    } else {
        $denda = 0;
    }

    if (empty($status_pengembalian)) {
        $errors[] = "Status Tidak Boleh Kosong";
    }

    if (empty($errors)) {
        $sql_cek = "SELECT judul_buku FROM barang WHERE judul_buku = ?";
        $stmt_cek = mysqli_prepare($koneksi, $sql_cek);
        mysqli_stmt_bind_param($stmt_cek, "s", $judul_buku);
        mysqli_stmt_execute($stmt_cek);
        $result_cek = mysqli_stmt_get_result($stmt_cek);

        if (mysqli_num_rows($result_cek) == 0) {
            $errors[] = "Buku Tidak Ditemukan di database";
        }

        mysqli_stmt_close($stmt_cek);
    }

    if (empty($errors)) {
        $sql = "INSERT INTO pengembalian_buku (judul_buku, nama_pengguna, tanggal_pinjam, tanggal_dikembalikan, keterlambatan, denda, status_pengembalian) VALUES (?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($koneksi, $sql);

        mysqli_stmt_bind_param($stmt, "sssssss", $judul_buku, $nama_pengguna, $tanggal_pinjam, $tanggal_dikembalikan, $keterlambatan, $denda, $status_pengembalian);

        if (mysqli_stmt_execute($stmt)) {
            $success = true;

            $sql_buku = "SELECT judul_buku FROM barang WHERE judul_buku = ?";
            $stmt_buku = mysqli_prepare($koneksi, $sql_buku);
            mysqli_stmt_bind_param($stmt_buku, "s", $judul_buku);
            mysqli_stmt_execute($stmt_buku);
            $result_buku = mysqli_stmt_get_result($stmt_buku);
            $buku = mysqli_fetch_assoc($result_buku);
            $nama_buku = $buku['judul_buku'];
            mysqli_stmt_close($stmt_buku);

            $nama_buku_sukses = $nama_buku;

            $judul_buku = "";
            $nama_pengguna = "";
            $tanggal_pinjam = "";
            $tanggal_dikembalikan = "";
            $keterlambatan = "";
            $denda = "";
            $status_pengembalian = "";
        } else {
            $errors[] = "Error: " . mysqli_error($koneksi);
        }

        mysqli_stmt_close($stmt);
    }
}

$sql_buku = "SELECT judul_buku FROM barang ORDER BY judul_buku ASC";
$result_buku = mysqli_query($koneksi, $sql_buku);

if (!isset($tanggal_dikembalikan)) {
    $tanggal_dikembalikan = date('Y-m-d');
}
require_once '../partials/header.php';
?>

<div class="container my-5 pt-7">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow border-0">

                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-arrow-return-left"></i> Pengembalian Buku
                    </h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="">

                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i>
                                <strong>Berhasil!</strong> Pengembalian Buku <strong><?= htmlspecialchars($nama_buku_sukses) ?></strong> Berhasil Dicatat.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i> <strong>Terjadi Kesalahan:</strong>
                                <ul class="mb-0 mt-2">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="nama_pengguna" class="form-label">Nama Peminjam</label>
                            <input type="text" 
                            class="form-control"
                            id="nama_pengguna"
                            name ="nama_pengguna"
                            value="<?= isset($nama_pengguna) ? htmlspecialchars($nama_pengguna) : ''?>"
                            placeholder="Masukkan nama Peminjam"
                            required>
                        </div>

                        <div class="mb-3">
                            <label for="judul_buku" class="form-label">Judul Buku</label>
                            <input type="text" 
                            class="form-control" 
                            id="judul_buku"
                            name="judul_buku"
                            value="<?= isset($judul_buku) ? htmlspecialchars($judul_buku) : ''?>"
                            placeholder="Judul buku yang dipinjam"
                            required>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                                <input type="date" 
                                class="form-control"
                                id="tanggal_pinjam"
                                name="tanggal-pinjam"
                                value="<?= isset($tanggal_pinjam) ? htmlspecialchars($tanggal_pinjam) : ''?>"
                                required>
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_dikembalikan" class="form-label">Tanggal Kembali</label>
                                <input type="date" 
                                class="form-control"
                                id="tanggal_dikembalikan"
                                name="tanggal_dikembalikan"
                                value="<?= isset($tanggal_dikembalikan) ? htmlspecialchars($tanggal_dikembalikan) : ''?>"
                                required>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label for="keterlambatan" class="form-label">Keterlambatan</label>
                                <input type="text" 
                                class="form-control"
                                id="keterlambatan"
                                name="keterlambatan" 
                                value="<?= isset($keterlambatan) ? htmlspecialchars($keterlambatan) : ''?>" 
                                placeholder="Contoh: 2 Hari"
                                required>
                            </div>

                            <div class="col-md-6">
                                <label for="denda" class="form-label">Denda</label>
                                <input type="text" 
                                class="form-control"
                                id="denda"
                                name="denda" 
                                value="<?= isset($denda) ? htmlspecialchars($denda) : ''?>" 
                                placeholder="Contoh: RP 2000"
                                required>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Status Pengembalian</label>
                            <select class="form-select" name="status_pengembalian" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="dikembalikan" <?= isset($status_pengembalian) == 'dikembalikan' ? 'selected' : '' ?>>Dikembalikan</option>
                                <option value="hilang" <?= isset($status_pengembalian) == 'hilang' ? 'selected' : '' ?>>Hilang</option>
                                <option value="rusak" <?= isset($status_pengembalian) == 'rusak' ? 'selected' : '' ?>>Rusak</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="../dashboard/index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Batal
                            </a>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Simpan Pengembalian
                            </button>
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