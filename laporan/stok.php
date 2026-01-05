<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';
$judul = "Laporan Stok Buku";
require_once '../partials/header.php';
?>
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center gap-2">
        <h2 class="mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-graph-up-arrow"></i> 
            Laporan Stok Buku Real-Time
        </h2>

        <div class="d-flex gap-2">
            <a href="../dashboard/index.php" class="btn btn-secondary d-flex align-items-center">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary d-flex align-items-center">
                <i class="bi bi-printer me-2"></i> Cetak Laporan
            </button>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-success">
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Judul Buku</th>
                        <th width="15%" class="text-center">Total Dikembalikan</th>
                        <th width="15%" class="text-center">Total Dipinjam</th>
                        <th width="15%" class="text-center">Stok Tersedia</th>
                        <th width="10%" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT
    b.id,
    b.judul_buku,
    b.stok AS stok_tersedia,

    COALESCE(SUM(pb.jumlah), 0) AS total_dipinjam,

    COALESCE(SUM(
        CASE 
            WHEN pmb.status_pengembalian = 'dikembalikan'
            THEN pb.jumlah
            ELSE 0
        END
    ), 0) AS total_dikembalikan

FROM buku b
LEFT JOIN peminjaman_buku pb ON pb.id_buku = b.id
LEFT JOIN pengembalian_buku pmb ON pmb.id_peminjaman = pb.id
GROUP BY b.id
ORDER BY b.judul_buku ASC
;


                    ";
                    $result = mysqli_query($koneksi, $sql);


                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $stok = (int) $row['stok_tersedia'];

                            if ($stok <= 0) {
                                $badge = '<span class="badge bg-danger">Habis</span>';
                            } elseif ($stok <= 5) {
                                $badge = '<span class="badge bg-warning text-dark">Stok Rendah</span>';
                            } else {
                                $badge = '<span class="badge bg-success">Tersedia</span>';
                            }

                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['judul_buku']) ?></td>
                                <td class="text-center"><?= number_format($row['total_dikembalikan']) ?></td>
                                <td class="text-center"><?= number_format($row['total_dipinjam']) ?></td>
                                <td class="text-center"><strong><?= number_format($stok) ?></strong></td>
                                <td class="text-center"><?= $badge ?></td>
                            </tr>

                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="6" class="text-center">Belum ada data buku.</td></tr>';
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
mysqli_close($koneksi);
require_once '../partials/footer.php';
?>