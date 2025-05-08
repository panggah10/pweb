<?php
include 'koneksi.php';

$nim = $_POST['nim'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$jk = $_POST['jk'];



$result = mysqli_query($koneksi, "UPDATE mahasiswa SET nama='$nama',alamat='$alamat',jk='$jk' WHERE nim='$nim' ");
if ($result) {
    // Kueri berhasil (atau menghasilkan hasil jika SELECT)
    header("location:index.php");
} else {
    // Kueri gagal
    echo "Error: " . $conn->error;
}
