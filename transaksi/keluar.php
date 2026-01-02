<?php
require_once '../middleware/cek_login.php';
require_once '../config/koneksi.php';

$judul = "Peminjaman Buku";
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_buku = intval($_POST['id_buku']);
    $nama_pengguna = trim($_POST['nama_pengguna']);
    $jumlah = intval($_POST['jumlah']);
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_dikembalikan = $_POST['tanggal_dikembalikan'];

    if ($id_buku <= 0) {
        $errors[] = "Buku harus dipilih.";
    }

    if ($nama_pengguna == "") {
        $errors[] = "Nama peminjam tidak boleh kosong.";
    }

    if ($jumlah <= 0) {
        $errors[] = "Jumlah harus lebih dari 0.";
    }

    if (!$tanggal_pinjam) {
        $errors[] = "Tanggal pinjam wajib diisi.";
    }

    if (!$tanggal_dikembalikan) {
        $errors[] = "Tanggal kembali wajib diisi.";
    }

    if (empty($errors)) {
        $sql = "SELECT judul_buku, stok FROM buku WHERE id = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_buku);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 0) {
            $errors[] = "Buku tidak ditemukan.";
        } else {
            $buku = mysqli_fetch_assoc($result);
            $judul_buku = $buku['judul_buku'];
            $stok = $buku['stok'];

            if ($stok < $jumlah) {
                $errors[] = "Stok tidak cukup. Stok tersedia: $stok";
            }
        }
        mysqli_stmt_close($stmt);
    }

    if (empty($errors)) {

        $sql = "INSERT INTO peminjaman_buku 
                (id_buku, nama_pengguna, jumlah, tanggal_pinjam, tanggal_dikembalikan)
                VALUES (?,?,?,?,?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "isiss",
            $id_buku,
            $nama_pengguna,
            $jumlah,
            $tanggal_pinjam,
            $tanggal_dikembalikan
        );

        if (mysqli_stmt_execute($stmt)) {

            $sql_update = "UPDATE buku SET stok = stok - ? WHERE id = ?";
            $stmt_update = mysqli_prepare($koneksi, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "ii", $jumlah, $id_buku);
            mysqli_stmt_execute($stmt_update);
            mysqli_stmt_close($stmt_update);

            $success = true;
        } else {
            $errors[] = "Gagal menyimpan data.";
        }
        mysqli_stmt_close($stmt);
    }
}

$sql_buku = "SELECT id, judul_buku FROM buku ORDER BY judul_buku ASC";
$result_buku = mysqli_query($koneksi, $sql_buku);

$tanggal_pinjam = date('Y-m-d');

require_once '../partials/header.php';
?>

<div class="container my-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0">
                <div class="card-header bg-danger text-white">
                     <h5 class="mb-0">
                        <i class="bi bi-arrow-return-left"></i> Peminjaman Buku
                    </h5>
                </div>

                <div class="card-body">

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            Peminjaman berhasil disimpan.
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $e): ?>
                                    <li><?= $e ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label>Nama Peminjam</label>
                            <input type="text" name="nama_pengguna" class="form-control" required>
                        </div>

                        <div class="mb-3 position-relative">
                            <label>Judul Buku</label>
                            <input type="text" id="judul_buku" class="form-control" placeholder="Ketik judul buku..."
                                autocomplete="off">
                            <input type="hidden" name="id_buku" id="id_buku" required>

                            <div id="hasil_buku" class="list-group position-absolute w-100" style="z-index:1000"></div>
                        </div>


                        <div class="mb-3">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" min="1" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" value="<?= $tanggal_pinjam ?>"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Tanggal Kembali</label>
                                <input type="date" name="tanggal_dikembalikan" class="form-control" required>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="../dashboard/index.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-danger">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('judul_buku').addEventListener('keyup', function () {
        let keyword = this.value;
        if (keyword.length < 2) {
            document.getElementById('hasil_buku').innerHTML = '';
            return;
        }

        fetch('../search/cari_buku.php?keyword=' + keyword)
            .then(res => res.text())
            .then(data => {
                document.getElementById('hasil_buku').innerHTML = data;
            });
    });

    function pilihBuku(id, judul) {
        document.getElementById('id_buku').value = id;
        document.getElementById('judul_buku').value = judul;
        document.getElementById('hasil_buku').innerHTML = '';
    }
</script>


<?php
require_once '../partials/footer.php';
mysqli_close($koneksi);
?>