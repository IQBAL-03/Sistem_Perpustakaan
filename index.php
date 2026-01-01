<?php
$judul = "Beranda";
require_once 'partials/header.php';
?>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>

    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex align-items-center">
                <div class="me-4 text-primary">
                    <i class="bi bi-book-half display-4"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold">
                        Selamat Datang di Sistem Perpustakaan
                    </h4>
                    <p class="mb-0 text-muted">
                        Sistem informasi perpustakaan untuk pengelolaan buku dan peminjaman.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-journal-bookmark fs-1 text-primary"></i>
                        <h5 class="mt-3">Data Buku</h5>
                        <p class="text-muted">
                            Lihat dan kelola koleksi buku perpustakaan.
                        </p>
                        <a href="/sistem-perpus/barang/index.php" class="btn btn-outline-primary btn-sm">
                            Lihat Data
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-arrow-left-right fs-1 text-primary"></i>
                        <h5 class="mt-3">Transaksi</h5>
                        <p class="text-muted">
                            Kelola barang masuk dan keluar perpustakaan.
                        </p>
                        <a href="/sistem-perpus/transaksi/masuk.php" class="btn btn-outline-primary btn-sm">
                            Kelola
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                        <h5 class="mt-3">Laporan</h5>
                        <p class="text-muted">
                            Lihat laporan stok dan aktivitas perpustakaan.
                        </p>
                        <a href="/sistem-perpus/laporan/stok.php" class="btn btn-outline-primary btn-sm">
                            Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 bg-light">
            <div class="card-body">
                <h6 class="fw-bold text-primary">
                    <i class="bi bi-info-circle"></i> Informasi
                </h6>
                <p class="mb-0 text-muted">
                    Gunakan menu di atas untuk mengelola sistem perpustakaan dengan mudah dan efisien.
                </p>
            </div>
        </div>
    </div>

<?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'staff'): ?>
    <div class="container my-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">
                <i class="bi bi-clipboard-check"></i> Halaman Petugas
            </h2>
            <p class="text-muted">
                Mencatat transaksi peminjaman dan pengembalian buku
            </p>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="bi bi-bookmark-plus text-primary fs-1"></i>
                        <h5 class="mt-3 fw-semibold">Peminjaman Buku</h5>
                        <p class="text-muted">
                            Catat transaksi peminjaman buku oleh anggota
                        </p>
                        <a href="#" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i> Catat Peminjaman
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-return-left text-success fs-1"></i>
                        <h5 class="mt-3 fw-semibold">Pengembalian Buku</h5>
                        <p class="text-muted">
                            Catat pengembalian buku dari anggota
                        </p>
                        <a href="#" class="btn btn-success">
                            <i class="bi bi-pencil-square"></i> Catat Pengembalian
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-table"></i> Riwayat Transaksi
                </h5>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Anggota</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Ahmad Fauzi</td>
                                <td>Algoritma dan Pemrograman</td>
                                <td>10-06-2025</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        Dipinjam
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Siti Aisyah</td>
                                <td>Basis Data MySQL</td>
                                <td>05-06-2025</td>
                                <td>12-06-2025</td>
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

<?php else: ?>

    <div class="container my-5">
        <div class="text-center mb-5">
            <i class="bi bi-book-half text-primary display-1"></i>
            <h1 class="fw-bold mt-3">
                Selamat Datang di Sistem Perpustakaan
            </h1>
            <p class="text-muted fs-5">
                Sistem pengelolaan perpustakaan berbasis web
                untuk memudahkan pencatatan dan pengelolaan buku
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-journal-bookmark-fill fs-1 text-primary"></i>
                        <h5 class="fw-semibold mt-3">Koleksi Buku</h5>
                        <p class="text-muted">
                            Menyimpan dan mengelola data buku secara terstruktur
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-clipboard-data fs-1 text-success"></i>
                        <h5 class="fw-semibold mt-3">Transaksi</h5>
                        <p class="text-muted">
                            Pencatatan peminjaman dan pengembalian buku secara rapi
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-people-fill fs-1 text-warning"></i>
                        <h5 class="fw-semibold mt-3">Manajemen Pengguna</h5>
                        <p class="text-muted">
                            Pengelolaan admin dan petugas sesuai hak akses
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php endif; ?>


<?php
require_once 'partials/footer.php';
?>