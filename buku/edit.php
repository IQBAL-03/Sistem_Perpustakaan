<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';
$judul = "Edit Buku";
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM buku WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$buku = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_buku = trim($_POST['kode_buku']);
    $judul_buku = trim($_POST['judul_buku']);
    $penulis = trim($_POST['penulis']);
    $penerbit = trim($_POST['penerbit']);
    $tahun = intval( $_POST['tahun']);
    $stok = intval( $_POST['stok']);
    $status = trim($_POST['status']);

    $errors = [];

    if (empty($kode_buku)) {
        $errors[] = "Kode buku Tidak Boleh Kosong";
    }

    if (empty($judul_buku)) {
        $errors[] = "Judul Buku Tidak Boleh Kosong";
    }

    if (empty($penulis)) {
        $errors[] = "Penulis Tidak Boleh Kosong";
    }

    if (empty($penerbit)) {
        $errors[] = "Penerbit Tidak Boleh Kosong";
    }

    if (empty($tahun)) {
        $errors[] = "Tahun Tidak Boleh Kosong";
    }

    if (empty($stok)) {
        $errors[] = "Stok Tidak Boleh Kosong";
    }

    if (empty($status)) {
        $errors[] = "Status Tidak Boleh Kosong";
    }

    if (empty($errors)) {
        $sql = "UPDATE buku SET kode_buku = ?, judul_buku = ?, penulis = ?, penerbit = ?, tahun = ?, stok = ?, status = ? WHERE id = ?";
        $stmt = mysqli_prepare($koneksi, $sql);

        mysqli_stmt_bind_param($stmt, "ssssiisi", $kode_buku, $judul_buku, $penulis, $penerbit, $tahun, $stok, $status, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?status=sukses_edit");
            exit();
        } else {
            $errors[] = "Error: " . mysqli_error($koneksi);
        }
        mysqli_stmt_close($stmt);
    }
} else {
    $kode_buku = $buku['kode_buku'];
    $judul_buku = $buku['judul_buku'];
    $penulis = $buku['penulis'];
    $penerbit = $buku['penerbit'];
    $tahun = $buku['tahun'];
    $stok = $buku['stok'];
    $status = $buku['status'];
}

require_once '../partials/header.php';
?>

<div class="container my-5 pt-5">
    <div class="row w-100 justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square"></i> Edit Data Buku
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Kode Buku</label>
                                <input type="text" name="kode_buku" class="form-control"
                                    value="<?= htmlspecialchars($kode_buku) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Judul Buku</label>
                                <input type="text" name="judul_buku" class="form-control"
                                    value="<?= htmlspecialchars($judul_buku) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Penulis</label>
                                <input type="text" name="penulis" class="form-control"
                                    value="<?= htmlspecialchars($penulis) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Penerbit</label>
                                <input type="text" name="penerbit" class="form-control"
                                    value="<?= htmlspecialchars($penerbit) ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tahun</label>
                                <input type="number" name="tahun" class="form-control"
                                    value="<?= htmlspecialchars($tahun) ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stok" class="form-control"
                                    value="<?= htmlspecialchars($stok) ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="tersedia" <?= $status == 'tersedia' ? 'selected' : '' ?>>
                                        Tersedia
                                    </option>
                                    <option value="kosong" <?= $status == 'kosong' ? 'selected' : '' ?>>
                                        Kosong
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
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