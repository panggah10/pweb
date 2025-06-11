<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'koneksi.php';

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, trim($_POST['username']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = "Semua kolom harus diisi!";
    } elseif ($password !== $confirm_password) {
        $error = "Kata sandi tidak cocok dengan konfirmasi!";
    } elseif (strlen($password) < 6) {
        $error = "Kata sandi minimal 6 karakter!";
    } else {
        $check_query = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($koneksi, $check_query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $error = "Username sudah digunakan!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = mysqli_prepare($koneksi, $insert_query);
            mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
            if (mysqli_stmt_execute($stmt)) {
                $success = "Registrasi berhasil! Silakan <a href='login.php'>login</a>.";
            } else {
                $error = "Gagal mendaftar: " . mysqli_error($koneksi);
            }
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - UIM YOGYA</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .error { color: red; }
        .success { color: green; }
        form { max-width: 300px; }
        label { display: block; margin-top: 10px; }
        input { width: 100%; padding: 5px; margin-top: 5px; }
        input[type="submit"] { margin-top: 15px; padding: 8px; }
    </style>
</head>
<body>
    <h2>Registrasi Sistem CRUD Mahasiswa UIM YOGYA</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" value="" required>
        <label>Kata Sandi:</label>
        <input type="password" name="password" value="" required>
        <label>Konfirmasi Kata Sandi:</label>
        <input type="password" name="confirm_password" value="" required>
        <input type="submit" value="Daftar">
    </form>
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</body>
</html>