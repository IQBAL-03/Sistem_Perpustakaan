<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';
$judul = "Dashboard Admin";
require_once '../partials/header.php';

$sql_total_buku = "SELECT COUNT(*) AS total FROM barang";
$result_total_buku = mysqli_query($koneksi, $sql_total_buku);
$row_total_buku = mysqli_fetch_assoc($result_total_buku);
$total_buku = $row_total_buku['total'];

$sql_total_stok = "
    SELECT 
        SUM(stok_tersedia) AS total_stok
    FROM (
        SELECT 
            b.id,
            COALESCE((SELECT SUM(jumlah) FROM barang_masuk WHERE id_barang = b.id), 0) - 
            COALESCE((SELECT SUM(jumlah) FROM barang_keluar WHERE id_barang = b.id), 0) AS stok_tersedia
        FROM barang b
    ) AS stok_per_barang
";
$result_total_stok = mysqli_query($koneksi, $sql_total_stok);
$row_total_stok = mysqli_fetch_assoc($result_total_stok);
$total_stok = $row_total_stok['total_stok'] ?? 0;
//transaksi

//

$sql_total_pengguna = "SELECT COUNT(*) AS total_pengguna FROM pengguna";
$result_total_pengguna= mysqli_query($koneksi, $sql_total_pengguna);
$row_total_pengguna = mysqli_fetch_assoc($result_total_pengguna);
$total_pengguna = $row_total_pengguna['total_pengguna'];
?>

<div class="container my-5">
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-shield-lock"></i> Dashboard Admin
        </h3>
        <p class="text-muted mb-0">
            Kelola data perpustakaan dan pengguna sistem
        </p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-book fs-1 text-primary me-3"></i>
                    <div>
                        <h5 class="mb-0 fw-bold"><?= number_format($total_buku)?></h5>
                        <small class="text-muted">Total Buku</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-collection fs-1 text-success me-3"></i>
                    <div>
                        <h5 class="mb-0 fw-bold"><?= number_format($total_stok) ?></h5>
                        <small class="text-muted">Total Stok Buku</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-arrow-left-right fs-1 text-warning me-3"></i>
                    <div>
                        <h5 class="mb-0 fw-bold">48</h5>
                        <small class="text-muted">Transaksi</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-people fs-1 text-success me-3"></i>
                    <div>
                        <h5 class="mb-0 fw-bold"><?= number_format($total_pengguna) ?></h5>
                        <small class="text-muted">Petugas</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-journal-bookmark fs-1 text-primary"></i>
                    <h5 class="mt-3 fw-semibold">Kelola Data Buku</h5>
                    <p class="text-muted">
                        Tambah, ubah, dan hapus data buku
                    </p>
                    <a href="../barang/index.php" class="btn btn-primary">
                        Kelola Buku
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-1 text-success"></i>
                    <h5 class="mt-3 fw-semibold">Kelola Pengguna</h5>
                    <p class="text-muted">
                        Atur admin dan petugas
                    </p>
                    <a href="#" class="btn btn-success">
                        Kelola User
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-text fs-1 text-warning"></i>
                    <h5 class="mt-3 fw-semibold">Laporan</h5>
                    <p class="text-muted">
                        Lihat laporan transaksi
                    </p>
                    <a href="#" class="btn btn-warning text-white">
                        Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-clock-history"></i> Aktivitas Terbaru
            </h5>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Aktivitas</th>
                            <th>Pengguna</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Menambahkan buku baru</td>
                            <td>Admin</td>
                            <td>12-06-2025</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Mengubah data pengguna</td>
                            <td>Admin</td>
                            <td>11-06-2025</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Menambah petugas</td>
                            <td>Admin</td>
                            <td>10-06-2025</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>


<?php
mysqli_close($koneksi);
require_once '../partials/footer.php';
?>