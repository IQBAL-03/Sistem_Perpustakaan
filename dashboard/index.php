<?php
session_start();
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';

if ($_SESSION['role'] == 'admin') {
    include 'admin.php';
} elseif ($_SESSION['role'] == 'staff') {
    include 'staff.php';
}

require_once '../partials/footer.php';
?>
