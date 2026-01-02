<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';
$judul = "Kelola Pengguna";
require_once '../partials/header.php';

$query = "SELECT * FROM pengguna ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<div class="container my-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">
            <i class="bi bi-people-fill"></i> Kelola Pengguna
        </h4>

        <div class="d-flex gap-2">
            <a href="../dashboard/index.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            

            <a href="tambah.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Pengguna
            </a>
        </div>
    </div>


    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Tanggal Dibuat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $badge = match ($row['role']) {
                                    'admin' => 'bg-danger',
                                    'petugas' => 'bg-primary',
                                    default => 'bg-secondary'
                                };
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row['nama']) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row['username']) ?></td>
                                    <td class="text-center">
                                        <span class="badge <?= $badge ?>">
                                            <?= ucfirst($row['role']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center"><?= date('d-m-Y', strtotime($row['tanggal_dibuat'])) ?></td>
                                    <td class="text-center">
                                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus pengguna ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada data pengguna
                                </td>
                              </tr>';
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