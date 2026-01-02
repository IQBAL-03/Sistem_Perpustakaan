<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

$sql = "DELETE FROM buku WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)){
    header("Location: index.php?status=sukses_hapus");
}else{
    header("Location: index.php?status=error_hapus");
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>