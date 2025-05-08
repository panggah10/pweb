<?php
include 'koneksi.php'; //menghubungkan dengan database

$nim = $_GET['id'];

$result = mysqli_query($koneksi, "DELETE from mahasiswa WHERE nim='$nim' ");
if ($result) {
    // Kueri berhasil (atau menghasilkan hasil jika SELECT)
    header("location:index.php");
} else {
    // Kueri gagal
    echo "Error: " . $conn->error;
}
