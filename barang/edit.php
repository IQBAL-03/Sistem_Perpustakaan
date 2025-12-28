<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';
$judul = "Edit Buku";
if (!isset($_GET['id']) || empty($_GET['id'])){
    header('Location: index.php');
    exit();
}
?>