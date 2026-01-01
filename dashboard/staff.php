<?php
require_once '../config/koneksi.php';
$judul = "Dashboard Staff";
require_once '../partials/header.php';
$sql_total_peminjaman = "SELECT COUNT(*) AS total FROM peminjaman_buku";
$result_peminjaman = mysqli_query($koneksi, $sql_total_peminjaman);
$row_peminjaman = mysqli_fetch_assoc($result_peminjaman);
$total_peminjaman = (int) $row_peminjaman['total'];

$sql_total_pengembalian = "SELECT COUNT(*) AS total FROM pengembalian_buku";
$result_pengembalian = mysqli_query($koneksi, $sql_total_pengembalian);
$row_pengembalian = mysqli_fetch_assoc($result_pengembalian);
$total_pengembalian = (int) $row_pengembalian['total'];

$sql_belum_kembali = "
    SELECT COUNT(*) AS total
    FROM peminjaman_buku p
    LEFT JOIN pengembalian_buku k 
        ON p.id = k.id_peminjaman
    WHERE k.id IS NULL
";
$result_belum_kembali = mysqli_query($koneksi, $sql_belum_kembali);
$row_belum_kembali = mysqli_fetch_assoc($result_belum_kembali);
$total_belum_kembali = (int) $row_belum_kembali['total'];

$sql_transaksi = "
    SELECT 
        p.id,
        p.nama_pengguna AS nama_anggota,
        b.judul_buku,
        p.tanggal_pinjam AS tanggal,
        IF(k.id IS NULL, 'Dipinjam', 'Dikembalikan') AS status
    FROM peminjaman_buku p
    JOIN barang b ON p.id_buku = b.id
    LEFT JOIN pengembalian_buku k 
        ON p.id = k.id_peminjaman
    ORDER BY p.created_at DESC
    LIMIT 10
";

$result_transaksi = mysqli_query($koneksi, $sql_transaksi);
?>

<div class="container my-4">

    <div class="mb-4">
        <h4 class="fw-bold">
            <i class="bi bi-person-workspace"></i> Dashboard Petugas
        </h4>
        <p class="text-muted mb-0">
            Kelola transaksi peminjaman dan pengembalian buku
        </p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Total Peminjaman</small>
                    <h3 class="fw-bold text-primary"><?= number_format($total_peminjaman) ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Total Pengembalian</small>
                    <h3 class="fw-bold text-success"><?= number_format($total_pengembalian) ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Buku Belum Kembali</small>
                    <h3 class="fw-bold text-danger"><?= number_format($total_belum_kembali) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-return-left fs-1 text-danger"></i>
                    <h5 class="mt-3">Catat Peminjaman</h5>
                    <p class="text-muted">
                        Tambahkan transaksi peminjaman buku
                    </p>
                    <a href="../transaksi/keluar.php" class="btn btn-danger">
                        <i class="bi bi-pencil-square"></i> Input Peminjaman
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-return-right fs-1 text-success"></i>
                    <h5 class="mt-3">Catat Pengembalian</h5>
                    <p class="text-muted">
                        Proses pengembalian buku
                    </p>
                    <a href="../transaksi/masuk.php" class="btn btn-success">
                        <i class="bi bi-pencil-square"></i> Input Pengembalian
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-clock-history"></i> Transaksi Terbaru
            </h6>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Anggota</th>
                            <th>Buku</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result_transaksi) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_transaksi)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nama_anggota']) ?></td>
                                    <td><?= htmlspecialchars($row['judul_buku']) ?></td>
                                    <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                                    <td>
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
    </div>

</div>


<?php
mysqli_close($koneksi);
require_once '../partials/footer.php';
?>