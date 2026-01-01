<?php
session_start();
require_once '../config/koneksi.php';
require_once '../middleware/cek_login.php';

if ($_SESSION['role'] == 'admin') {
    include 'admin.php';
} elseif ($_SESSION['role'] == 'staff') {
    include 'staff.php';
}

require_once '../partials/footer.php';
?>
