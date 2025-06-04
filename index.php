<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BELAJAR CRUD PHP</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
</head>

<body>
    <h2>BELAJAR CRUD MAHASISWA UIM YOGYA</h2>
</br>
    <!-- Form Pencarian -->
    <form action="" method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan NIM atau Nama" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-primary">Cari</button>
    </div>
</form>
    <!-- menghubungkan dengan file tambah.php -->

    <a href="tambah.php">+TAMBAH MAHASISWA</a>
    <table class="table">
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>Aksi</th>
        </tr>
        <?php
        include 'koneksi.php'; //mengambil file
       // Pengaturan Paging
        $limit = 5; // Jumlah data per halaman
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        
        // Pencarian
        $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
        $where_clause = $search ? "WHERE nim LIKE '%$search%' OR nama LIKE '%$search%'" : '';
        
        // Query untuk menghitung total data
        $total_query = "SELECT COUNT(*) as total FROM mahasiswa $where_clause";
        $total_result = mysqli_query($koneksi, $total_query);
        $total_data = mysqli_fetch_assoc($total_result)['total'];
        $total_pages = ceil($total_data / $limit);
        
        // Query utama dengan limit dan pencarian
        $query = "SELECT * FROM mahasiswa $where_clause LIMIT $start, $limit";
        $data = mysqli_query($koneksi, $query);
        
        $no = $start + 1;
        while ($d = mysqli_fetch_array($data)) {
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $d['nim']; ?></td>
            <td><?php echo $d['nama']; ?></td>
            <td><?php echo $d['alamat']; ?></td>
            <td><?php echo $d['jk']; ?></td>
            <td><a href="edit.php?id=<?php echo $d['nim']; ?>"><button type="button"
                        class="btn btn-primary">EDIT</button></a>|<a href="hapus.php?id=<?php echo $d['nim']; ?>">HAPUS</a>
            </td>
        </tr>
        <?php
        }
        ?>
    </table>


    <!-- Navigasi Paging -->
    <?php if ($total_data > 0): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
            </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                <a class="page-link"
                    href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->
</body>

</html>
