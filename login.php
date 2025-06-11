<?php
// Mengaktifkan error untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Memulai sesi untuk menyimpan status login
session_start();
// Menghubungkan ke database
include 'koneksi.php';

// Jika sudah login, arahkan ke halaman utama
if (isset($_SESSION['username'])) {
    header("Location: index2.php");
    exit;
}

// Variabel untuk pesan error
$error = '';

// Proses form saat tombol login diklik
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan hapus spasi di awal/akhir
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Cek username di database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        // Verifikasi kata sandi yang dienkripsi
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index2.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - UIM YOGYA</title>
    <style>
        /* Styling sederhana untuk tampilan rapi */
        body { font-family: Arial, sans-serif; margin: 20px; }
        .error { color: red; }
        form { max-width: 300px; }
        label { display: block; margin-top: 10px; }
        input { width: 100%; padding: 5px; }
        input[type="submit"] { margin-top: 10px; padding: 5px; }
    </style>
</head>
<body>
    <h2>Login Mahasiswa UIM YOGYA</h2>
    <!-- Tampilkan pesan error jika ada -->
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <input type="submit" value="Login">
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</body>
</html>