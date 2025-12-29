<?php
require_once '../config/koneksi.php';
$judul = "Dashboard Staff";
require_once '../partials/header.php';
?>

<div class="container my-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h4 class="fw-bold">
            <i class="bi bi-person-workspace"></i> Dashboard Petugas
        </h4>
        <p class="text-muted mb-0">
            Kelola transaksi peminjaman dan pengembalian buku
        </p>
    </div>

    <!-- KARTU RINGKAS -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Peminjaman Hari Ini</small>
                    <h3 class="fw-bold text-primary">12</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Pengembalian Hari Ini</small>
                    <h3 class="fw-bold text-success">9</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Buku Belum Kembali</small>
                    <h3 class="fw-bold text-danger">5</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- AKSI CEPAT -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-journal-plus fs-1 text-primary"></i>
                    <h5 class="mt-3">Catat Peminjaman</h5>
                    <p class="text-muted">
                        Tambahkan transaksi peminjaman buku
                    </p>
                    <a href="#" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Input Peminjaman
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-return-left fs-1 text-success"></i>
                    <h5 class="mt-3">Catat Pengembalian</h5>
                    <p class="text-muted">
                        Proses pengembalian buku
                    </p>
                    <a href="#" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Input Pengembalian
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL TRANSAKSI TERBARU -->
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
                        <tr>
                            <td>Ahmad</td>
                            <td>Algoritma Dasar</td>
                            <td>12-06-2025</td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    Dipinjam
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Siti</td>
                            <td>Basis Data</td>
                            <td>11-06-2025</td>
                            <td>
                                <span class="badge bg-success">
                                    Dikembalikan
                                </span>
                            </td>
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