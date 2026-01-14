<?php
$judul = "Beranda";
require_once 'partials/header.php';
?>
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
<?php
require_once 'partials/footer.php';
?>