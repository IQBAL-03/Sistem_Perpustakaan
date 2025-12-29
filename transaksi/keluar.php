<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';
$judul = "Peminjaman";
$errors = [];
$success = false;
$stok_tersedia = null;
$jumlah_sukses = 0;
$nama_barang_sukses = "";
$stok_setelah_sukses = 0;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $judul_buku = trim($_POST["judul_buku"]);
    $nama_pengguna = trim($_POST['nama_pengguna']);
    $tanggal_pinjam = trim($_POST['tanggal-pinjam']);
    $tanggal_dikembalikan = trim($_POST['tanggal_dikembalikan']);
    $status_peminjaman = trim($_POST['status_pengembalian']);

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

}
require_once '../partials/header.php';
?>

<div class="container my-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0">
                
                <!-- Header -->
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-journal-plus"></i> Peminjaman Buku
                    </h5>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <form method="POST" action="">

                        <!-- Success Message -->
                        <div class="alert alert-success d-none" id="success-alert">
                            <i class="fas fa-check-circle"></i>
                            <strong>Berhasil!</strong> Peminjaman Buku Dicatat.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>

                        <!-- Error Message -->
                        <div class="alert alert-danger d-none" id="error-alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Terjadi Kesalahan:</strong>
                            <ul class="mb-0 mt-2"></ul>
                        </div>

                        <!-- Nama Peminjam -->
                        <div class="mb-3">
                            <label for="nama_pengguna" class="form-label">Nama Peminjam</label>
                            <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" placeholder="Masukkan nama peminjam" required>
                        </div>

                        <!-- Judul Buku -->
                        <div class="mb-3">
                            <label for="judul_buku" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="judul_buku" name="judul_buku" placeholder="Masukkan judul buku" required>
                        </div>

                        <!-- Tanggal Pinjam & Kembali -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required>
                            </div>
                        </div>

                        <!-- Status Peminjaman -->
                        <div class="mt-3">
                            <label class="form-label">Status Peminjaman</label>
                            <select class="form-select" name="status_peminjaman" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="dipinjam">Dipinjam</option>
                                <option value="hilang">Hilang</option>
                                <option value="rusak">Rusak</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="../dashboard/index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-check-circle"></i> Simpan Peminjaman
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