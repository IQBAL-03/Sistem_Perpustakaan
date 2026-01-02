<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';

$nama = $_GET['nama'] ?? '';

$sql = "
SELECT 
    pb.id AS id_peminjaman,
    pb.id_buku,
    b.judul_buku,
    pb.tanggal_pinjam,
    pb.tanggal_dikembalikan
FROM peminjaman_buku pb
JOIN buku b ON pb.id_buku = b.id
WHERE pb.nama_pengguna = ?
AND pb.status = 'dipinjam'
LIMIT 1
";

$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "s", $nama);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($data = mysqli_fetch_assoc($result)) {
    echo json_encode($data);
} else {
    echo json_encode([]);
}
