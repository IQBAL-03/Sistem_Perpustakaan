<?php
require_once '../config/koneksi.php';

$keyword = $_GET['keyword'];

$query = mysqli_prepare(
    $koneksi,
    "SELECT id, judul_buku FROM barang 
     WHERE judul_buku LIKE CONCAT('%', ?, '%') 
     LIMIT 10"
);
mysqli_stmt_bind_param($query, "s", $keyword);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);

while ($b = mysqli_fetch_assoc($result)) {
    echo '<button type="button" class="list-group-item list-group-item-action"
            onclick="pilihBuku(' . $b['id'] . ', \'' . htmlspecialchars($b['judul_buku'], ENT_QUOTES) . '\')">
            ' . $b['judul_buku'] . '
          </button>';
}
