<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'koneksi.php';

if (isset($_SESSION['username'])) {
    header("Location: index2.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, trim($_POST['username']));
    $password = trim($_POST['password']);

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        $error = "Query gagal: " . mysqli_error($koneksi);
    } elseif (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - UIM YOGYA</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .error { color: red; }
        form { max-width: 300px; }
        label { display: block; margin-top: 10px; }
        input { width: 100%; padding: 5px; margin-top: 5px; }
        input[type="submit"] { margin-top: 15px; padding: 8px; }
    </style>
</head>
<body>
    <h2>Login Sistem CRUD Mahasiswa UIM YOGYA</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" value="" required>
        <label>Password:</label>
        <input type="password" name="password" value="" required>
        <input type="submit" value="Login">
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</body>
</html>