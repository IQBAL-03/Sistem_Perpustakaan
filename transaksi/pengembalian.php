<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';

$judul = "Pengembalian Buku";
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_peminjaman = intval($_POST['id_peminjaman']);
    $tanggal_dikembalikan = $_POST['tanggal_dikembalikan'];
    $keterlambatan = intval($_POST['keterlambatan']);
    $denda = intval($_POST['denda']);
    $status_pengembalian = $_POST['status_pengembalian'];

    if ($id_peminjaman <= 0) {
        $errors[] = "Peminjaman tidak valid";
    }

    if (!$tanggal_dikembalikan) {
        $errors[] = "Tanggal kembali wajib diisi";
    }

    if ($keterlambatan < 0) {
        $errors[] = "Keterlambatan tidak valid";
    }

    if ($denda < 0) {
        $errors[] = "Denda tidak valid";
    }

    if (!$status_pengembalian) {
        $errors[] = "Status pengembalian wajib diisi";
    }

    if (empty($errors)) {
        $q = mysqli_query(
            $koneksi,
            "SELECT * FROM peminjaman_buku WHERE id = $id_peminjaman AND status='dipinjam'"
        );

        if (mysqli_num_rows($q) == 0) {
            $errors[] = "Data peminjaman tidak ditemukan atau sudah dikembalikan";
        } else {
            $pinjam = mysqli_fetch_assoc($q);
        }
    }

    if (empty($errors)) {

        $sql = "INSERT INTO pengembalian_buku 
                (id_peminjaman, id_buku, tanggal_dikembalikan, keterlambatan, denda, status_pengembalian)
                VALUES (?,?,?,?,?,?)";

        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "iisiis",
            $id_peminjaman,
            $pinjam['id_buku'],
            $tanggal_dikembalikan,
            $keterlambatan,
            $denda,
            $status_pengembalian
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        mysqli_query(
            $koneksi,
            "UPDATE peminjaman_buku 
             SET status='dikembalikan' 
             WHERE id=$id_peminjaman"
        );

        mysqli_query(
            $koneksi,
            "UPDATE buku 
             SET stok = stok + {$pinjam['jumlah']} 
             WHERE id = {$pinjam['id_buku']}"
        );

        $success = true;
    }
}

require_once '../partials/header.php';
?>

<div class="container my-5 pt-6">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-arrow-return-right"></i>Pengembalian Buku
                    </h5>
                </div>
                <div class="card-body">

                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Pengembalian berhasil disimpan.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($errors): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php foreach ($errors as $e): ?>
                                    <li><?= $e ?></li>
                                <?php endforeach ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label>Nama Peminjam</label>
                            <div class="input-group">
                                <input type="text" id="nama_pengguna" class="form-control">
                                <button type="button" class="btn btn-success" onclick="cariPeminjaman()">Cari</button>
                            </div>
                        </div>

                        <input type="hidden" name="id_peminjaman" id="id_peminjaman">
                        <input type="hidden" name="id_buku" id="id_buku">

                        <div class="mb-3">
                            <label>Judul Buku</label>
                            <input type="text" id="judul_buku" class="form-control" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Tanggal Pinjam</label>
                                <input type="date" id="tanggal_pinjam" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Tanggal Kembali</label>
                                <input type="date" name="tanggal_dikembalikan" id="tanggal_dikembalikan"
                                    class="form-control" readonly>
                            </div>
                        </div>


                        <div class="row mt-3">
                            <div class="col">
                                <label>Keterlambatan (hari)</label>
                                <input type="number" name="keterlambatan" class="form-control">
                            </div>
                            <div class="col">
                                <label>Denda</label>
                                <input type="number" name="denda" class="form-control">
                            </div>
                        </div>

                        <div class="mt-3">
                            <label>Status</label>
                            <select name="status_pengembalian" class="form-select">
                                <option value="dikembalikan">Dikembalikan</option>
                                <option value="hilang">Hilang</option>
                                <option value="rusak">Rusak</option>
                            </select>
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="../dashboard/index.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function cariPeminjaman() {
        let nama = document.getElementById('nama_pengguna').value;

        fetch('../search/cari_peminjaman.php?nama=' + nama)
            .then(res => res.json())
            .then(data => {
                if (!data.id_peminjaman) {
                    alert('Data peminjaman tidak ditemukan');
                    return;
                }

                document.getElementById('id_peminjaman').value = data.id_peminjaman;
                document.getElementById('id_buku').value = data.id_buku;
                document.getElementById('judul_buku').value = data.judul_buku;
                document.getElementById('tanggal_pinjam').value = data.tanggal_pinjam;
                document.getElementById('tanggal_dikembalikan').value = data.tanggal_dikembalikan;
            });
    }
</script>


<?php require_once '../partials/footer.php';
mysqli_close($koneksi);
?>