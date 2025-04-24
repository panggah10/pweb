<?php
//koneksi ke database
$koneksi = mysqli_connect("localhost","root","","akademik");
//Cek koneksi
if(mysqli_connect_errno()){
    echo "Koneksi database gagal : ".mysqli_connect_errno();
}else{
    // echo "berhasil";
}
?>