<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($judul) ? $judul : 'Sistem Perpustakaan' ?></title>
    <link rel="icon" type="image/x-icon" href="../image/icon.png">
    <link rel="icon" type="image/x-icon" href="image/icon.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <div id="loader" class="position-fixed vh-100 vw-100 d-flex justify-content-center align-items-center bg-white"
        style="z-index: 9999; top: 0; left: 0;">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <?php
            if (isset($_SESSION['user_id'])){
                $link = 'href = "/sistem-perpus/dashboard/index.php"';
            }else{
                $link ='';
            }
            ?>
            <a class="navbar-brand fw-bold" <?=$link?>>
                <i class="bi bi-book-half"></i> Sistem Perpustakaan</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="offcanvas offcanvas-end bg-primary text-white" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title fw-bold" id="offcanvasNavbarLabel">
                        <i class="bi bi-book-half"></i> Menu
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/sistem-perpus/buku/index.php">
                                    <i class="bi bi-journal-bookmark"></i> Data Buku
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sistem-perpus/laporan/stok.php">
                                    <i class="bi bi-file-earmark-text"></i> Laporan Stok Buku
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/sistem-perpus/dashboard/index.php">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="transaksiDropdown" role="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-exchange-alt"></i> Transaksi
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="/sistem-perpus/transaksi/pengembalian.php">
                                            <i class="fas fa-arrow-up text-success"></i> Pengembalian
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/sistem-perpus/transaksi/peminjaman.php">
                                            <i class="fas fa-arrow-up text-danger"></i> Peminjaman
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item">
                                <a href="/sistem-perpus/profil/profil.php" class="nav-link user-badge d-flex align-items-center">
                                    <?php if (!empty($_SESSION['foto'])): ?>
                                        <img src="/sistem-perpus/foto_profil/<?= $_SESSION['foto']; ?>" 
                                             class="rounded-circle border border-white" 
                                             width="30" height="30" 
                                             style="object-fit: cover; margin-right: 8px;">
                                    <?php else: ?>
                                        <i class="fas fa-user-circle me-1"></i>
                                    <?php endif; ?>
                                    <?= htmlspecialchars($_SESSION['nama']) ?>
                                </a>
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
        </div>
    </nav>

    <div class="content-wrapper flex-grow-1">
        <div class="container">