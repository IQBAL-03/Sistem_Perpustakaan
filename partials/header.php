<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($judul) ? $judul : 'Sistem Perpustakaan' ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/sistem-perpus/index.php">
                <i class="bi bi-book-half"></i> Sistem Perpustakaan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="/sistem-perpus/barang/index.php">
                            <i class="bi bi-journal-bookmark"></i> Data Buku
                        </a>
                    </li>
                    <?php
                    //fitur admin
                    ?>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/sistem-perpus/dashboard/index.php">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/sistem-perpus/laporan/stok.php">
                            <i class="bi bi-file-earmark-text"></i> Laporan Stok Buku
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="transaksiDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-exchange-alt"></i> Transaksi
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="/sistem-perpus/transaksi/masuk.php">
                                        <i class="fas fa-arrow-up text-success"></i> Barang Masuk
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/sistem-perpus/transaksi/keluar.php">
                                        <i class="fas fa-arrow-up text-danger"></i> Barang Keluar
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <span class="nav-link user-badge">
                                <i class="fas fa-user-circle"></i>
                                <?= htmlspecialchars($_SESSION['nama']) ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/sistem-perpus/auth/logout.php">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/sistem-perpus/auth/login.php">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-wrapper flex-grow-1">
        <div class="container">