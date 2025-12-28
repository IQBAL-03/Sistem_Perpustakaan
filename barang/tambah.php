<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';
$judul = "Tambah Buku Baru";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_buku = trim($_POST['kode_buku']);
    $judul_buku = trim($_POST['judul_buku']);
    $penulis = trim($_POST['penulis']);
    $penerbit = trim($_POST['penerbit']);
    $tahun = (int) $_POST['tahun'];
    $stok = (int) $_POST['stok'];
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
        $sql = "INSERT INTO barang (kode_buku, judul_buku, penulis, penerbit, tahun, stok, status) VALUES (?,?,?,?,?,?,?)";

        $stmt = mysqli_prepare($koneksi, $sql);

        mysqli_stmt_bind_param($stmt, "ssssiis", $kode_buku, $judul_buku, $penulis, $penerbit, $tahun, $stok, $status);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?status=sukses_tambah");
            exit();
        } else {
            $errors[] = "Error: " . mysqli_error($koneksi);
        }

        mysqli_stmt_close($stmt);
    }
}

require_once '../partials/header.php';
?>

<div class="container my-5 pt-5">
    <div class="row w-100 justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow">

                <!-- HEADER -->
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-square"></i> Tambah Buku Baru
                    </h5>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- BODY -->
                <div class="card-body">
                    <form method="POST" action="">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="kode_buku" class="form-label">Kode Buku</label>
                                <input type="text" class="form-control" id="kode_buku" name="kode_buku"
                                    value="<?= isset($kode_buku) ? htmlspecialchars($kode_buku) : '' ?>"
                                    placeholder="Contoh: BK001" required>
                            </div>

                            <div class="col-md-6">
                                <label for="judul-buku" class="form-label">Judul Buku</label>
                                <input type="text" class="form-control" id="judul_buku" name="judul_buku"
                                    value="<?= isset($judul_buku) ? htmlspecialchars($judul_buku) : '' ?>"
                                    placeholder="Judul buku" required>
                            </div>

                            <div class="col-md-6">
                                <label for="penulis" class="form-label">Penulis</label>
                                <input type="text" name="penulis" id="penulis" class="form-control"
                                    value="<?= isset($penulis) ? htmlspecialchars($penulis) : '' ?>"
                                    placeholder="Nama penulis" required>
                            </div>

                            <div class="col-md-6">
                                <label for="penerbit" class="form-label">Penerbit</label>
                                <input type="text" name="penerbit" id="penerbit" class="form-control"
                                    value="<?= isset($penerbit) ? htmlspecialchars($penerbit) : '' ?>"
                                    placeholder="Nama penerbit" required>
                            </div>

                            <div class="col-md-4">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="number" name="tahun" id="tahun" class="form-control"
                                    value="<?= isset($tahun) ? htmlspecialchars($tahun) : '' ?>" placeholder="2024"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label for="jumlah" class="form-label">Stok</label>
                                <input type="number" name="stok" id="stok" class="form-control"
                                    value="<?= isset($stok) ? htmlspecialchars($stok) : '' ?>" placeholder="Jumlah"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="tersedia">Tersedia</option>
                                    <option value="kosong">Kosong</option>
                                </select>
                            </div>

                        </div>

                        <!-- AKSI -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Batal
                            </a>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan Buku
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