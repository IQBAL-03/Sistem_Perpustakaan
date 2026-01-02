<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';
$judul = "Dashboard Admin";
require_once '../partials/header.php';

$sql_total_buku = "SELECT COUNT(*) AS total FROM buku where stok > 0";
$result_total_buku = mysqli_query($koneksi, $sql_total_buku);
$row_total_buku = mysqli_fetch_assoc($result_total_buku);
$total_buku = $row_total_buku['total'];

$sql_total_stok = "SELECT SUM(stok) AS total_stok FROM buku";
$result_total_stok = mysqli_query($koneksi, $sql_total_stok);
$row_total_stok = mysqli_fetch_assoc($result_total_stok);
$total_stok = (int) ($row_total_stok['total_stok'] ?? 0);


$sql_total_peminjaman = "SELECT COUNT(*) AS total FROM peminjaman_buku";
$result_peminjaman = mysqli_query($koneksi, $sql_total_peminjaman);
$row_peminjaman = mysqli_fetch_assoc($result_peminjaman);
$total_peminjaman = (int) $row_peminjaman['total'];

$sql_total_pengembalian = "SELECT COUNT(*) AS total FROM pengembalian_buku";
$result_pengembalian = mysqli_query($koneksi, $sql_total_pengembalian);
$row_pengembalian = mysqli_fetch_assoc($result_pengembalian);
$total_pengembalian = (int) $row_pengembalian['total'];

$total_transaksi = $total_peminjaman + $total_pengembalian;

$sql_total_pengguna = "SELECT COUNT(*) AS total_pengguna FROM pengguna";
$result_total_pengguna = mysqli_query($koneksi, $sql_total_pengguna);
$row_total_pengguna = mysqli_fetch_assoc($result_total_pengguna);
$total_pengguna = $row_total_pengguna['total_pengguna'];


$sql_transaksi = "
    SELECT 
        p.id,
        p.nama_pengguna AS nama_peminjam,
        b.judul_buku,
        p.jumlah,
        p.tanggal_pinjam AS tanggal,
        IF(k.id IS NULL, 'Dipinjam', 'Dikembalikan') AS status
    FROM peminjaman_buku p
    JOIN buku b ON p.id_buku = b.id
    LEFT JOIN pengembalian_buku k ON p.id = k.id_peminjaman
    ORDER BY p.created_at DESC
    LIMIT 10
";
$result_transaksi = mysqli_query($koneksi, $sql_transaksi);
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
                        <h5 class="mb-0 fw-bold"><?= number_format($total_buku) ?></h5>
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
                        <h5 class="mb-0 fw-bold"><?= number_format($total_transaksi) ?></h5>
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
                    <a href="../buku/index.php" class="btn btn-primary">
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
                    <a href="../kelola_pengguna/index.php" class="btn btn-success">
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
                    <a href="../laporan/stok.php" class="btn btn-warning text-white">
                        Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>Nama Peminjam</th>
                    <th>Buku</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_transaksi) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result_transaksi)): ?>
                        <tr>
                            <td class="text-center"><?= htmlspecialchars($row['nama_peminjam']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['judul_buku']) ?></td>
                            <td class="text-center">
                                <span class="badge bg-secondary text-white">
                                    <?= $row['jumlah'] ?> Buku
                                </span>
                            </td>
                            <td class="text-center"><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                            <td class="text-center">
                                <?php if ($row['status'] === 'Dipinjam'): ?>
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Dikembalikan</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Belum ada transaksi
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<?php
mysqli_close($koneksi);
require_once '../partials/footer.php';
?>