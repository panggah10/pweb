<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BELAJAR CRUD PHP</title>
</head>

<body>
    <h2>FITUR EDIT MAHASISWA UIM YOGYA</h2>
    </br>
    <?php
    include 'koneksi.php'; //mengkoneksi dengan database 
    $nim = $_GET['id']; //mengambil data 'id' dari file index.php
    $data = mysqli_query($koneksi, "SELECT * from mahasiswa where nim='$nim'"); //query tampil data dari database

    while ($d = mysqli_fetch_array($data)) {
    ?>
        <!-- menghubungkan dengan file tambah.php -->
        <a href="index.php">KEMBALI</a>
        <form action="edit_aksi.php" method="POST">
            <table>
                <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td><input type="hidden" name="nim" id="nim" value="<?php echo $d['nim']; ?>"></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><input type="text" name="nama" id="nama" value="<?php echo $d['nama']; ?>"></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>
                        <textarea name="alamat" id="alamat" value=""><?php echo $d['alamat']; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>
                        <select name="jk" id="jk">
                            <option value=""><?php echo $d['jk']; ?></option>
                            <option value="laki-laki">Laki-Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><input type="submit" value="SIMPAN"></td>
                </tr>


            </table>

        </form>
    <?php
    }
    ?>
</body>

</html>