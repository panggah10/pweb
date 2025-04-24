<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BELAJAR CRUD PHP</title>
</head>
<body>
    <h2>BELAJAR CRUD MAHASISWA UIM YOGYA</h2>
    </br>
    <!-- menghubungkan dengan file tambah.php -->
    <a href="tambah.php">+TAMBAH MAHASISWA</a>
    <table border="1">
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>Aksi</th>
        </tr>
        <?php
            include 'koneksi.php';//mengambil file
            $no = 1;//variabel penomoran
            //query untuk menampilkan data
            $data = mysqli_query($koneksi,"SELECT * from mahasiswa");
            //memecah array
            while($d=mysqli_fetch_array($data)){
        ?>
        <tr>
            <td><?php echo $no++;?></td>
            <td><?php echo $d['nim'];?></td>
            <td><?php echo $d['nama'];?></td>
            <td><?php echo $d['alamat'];?></td>
            <td><?php echo $d['jk'];?></td>
            <td>EDIT|HAPUS</td>
        </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>