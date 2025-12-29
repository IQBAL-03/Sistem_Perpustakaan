<?php
require_once '../config/koneksi.php';
$judul = "Daftar Buku";
require_once '../partials/header.php';
?>

<div class="container my-5">

    <!-- JUDUL -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">
                <i class="bi bi-book"></i> Daftar Buku
            </h3>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="tambah.php" class="btn btn-success">
                <i class="bi bi-plus"></i> Tambah Buku Baru
            </a>
        <?php else: ?>
            <span class="text-muted">
                <i class="bi bi-info-circle"></i> Login untuk mengelola buku
            </span>
        <?php endif; ?>
    </div>

    <?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'sukses_tambah') {
            echo '<div class = "alert alert-success">Buku Baru Berhasil Ditambahkan !</div>';
        } elseif ($_GET['status'] == 'sukses_edit') {
            echo '<div class="alert alert-info">Data Buku Berhasil Diperbarui !</div>';
        } elseif ($_GET['status'] == 'sukses_hapus') {
            echo '<div class="alert alert-warning">Buku Berhasil Dihapus !</div>';
        } 
    }
    ?>

    <!-- TABEL DATA BUKU -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th width="4%">No</th>
                            <th width="10%">Kode Buku</th>
                            <th width="22%">Judul Buku</th>
                            <th width="16%">Penulis</th>
                            <th width="16%">Penerbit</th>
                            <th width="6%">Tahun</th>
                            <th width="6%">Stok</th>
                            <th width="5%">Status</th>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <th width="15%" class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>

                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM barang ORDER BY kode_buku ASC";
                        $result = mysqli_query($koneksi, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['kode_buku']) ?></td>
                                    <td><?= htmlspecialchars($row['judul_buku']) ?></td>
                                    <td><?= htmlspecialchars($row['penulis']) ?></td>
                                    <td><?= htmlspecialchars($row['penerbit']) ?></td>
                                    <td><?= htmlspecialchars($row['tahun']) ?></td>
                                    <td><?= htmlspecialchars($row['stok']) ?></td>
                                    <td><?= htmlspecialchars($row['status']) ?></td>
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <td class="text-center">
                                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin Menghapus Buku ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php
                            }
                        } else {
                            $colspan = isset($_SESSION['user_id']) ? 5 : 4;
                            echo '<tr><td colspan= "' . $colspan . '" class="text-center">Belum Ada Data Buku.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>


<?php
mysqli_close($koneksi);
require_once '../partials/footer.php';
?>