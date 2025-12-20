<?php
session_start();
if (isset($_SESSION['id'])) {
    header("Location: ../barang/index.php");
    exit();
}
require_once '../config/koneksi.php';
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Username dan Password tidak boleh kosong";
    } else {
        $sql = "SELECT * FROM pengguna WHERE username = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: ../barang/index.php?status=login_sukses");
                exit();
            } else {
                $error = "Password salah !";
            }
        } else {
            $error = "Username Tidak Ditemukan";
        }

        mysqli_stmt_close($stmt);
    }
}
$judul = "Login";
?>
<?php
mysqli_close($koneksi);
?>