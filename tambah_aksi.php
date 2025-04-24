<?php
include 'koneksi.php';


$nim = $_POST['nim'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$jk = $_POST['jk'];

mysqli_query($koneksi,"INSERT INTO mahasiswa values ('','$nama','$alamat','$jk')");

header("location:index.php")
?>