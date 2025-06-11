<?php
// Mengaktifkan error untuk debugging (bantu mahasiswa lihat masalah)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Memulai sesi untuk menyimpan status login
session_start();
// Menghubungkan ke database
include 'koneksi.php';

// Jika sudah login, arahkan ke halaman utama
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Variabel untuk pesan error atau sukses
$error = '';
$success = '';

// Proses form saat tombol daftar diklik
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan hapus spasi di awal/akhir
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Cek apakah ada data yang kosong
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = "Semua kolom harus diisi!";
    // Cek apakah kata sandi cocok
    } elseif ($password != $confirm_password) {
        $error = "Kata sandi tidak cocok!";
    // Cek panjang kata sandi
    } elseif (strlen($password) < 6) {
        $error = "Kata sandi minimal 6 karakter!";
    } else {
        // Cek apakah username sudah ada
        $check_query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($koneksi, $check_query);
        if (mysqli_num_rows($result) > 0) {
            $error = "Username sudah digunakan!";
        } else {
            // Enkripsi kata sandi untuk keamanan
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Simpan data ke database
            $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
            if (mysqli_query($koneksi, $insert_query)) {
                $success = "Registrasi berhasil! Silakan <a href='login.php'>login</a>.";
            } else {
                $error = "Gagal mendaftar: " . mysqli_error($koneksi);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - UIM YOGYA</title>
    <style>
        /* Styling sederhana untuk tampilan rapi */
        body { font-family: Arial, sans-serif; margin: 20px; }
        .error { color: red; }
        .success { color: green; }
        form { max-width: 300px; }
        label { display: block; margin-top: 10px; }
        input { width: 100%; padding: 5px; }
        input[type="submit"] { margin-top: 10px; padding: 5px; }
    </style>
</head>
<body>
    <h2>Registrasi Mahasiswa UIM YOGYA</h2>
    <!-- Tampilkan pesan error jika ada -->
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <!-- Tampilkan pesan sukses jika ada -->
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" required>
        <label>Kata Sandi:</label>
        <input type="password" name="password" required>
        <label>Konfirmasi Kata Sandi:</label>
        <input type="password" name="confirm_password" required>
        <input type="submit" value="Daftar">
    </form>
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</body>
</html>