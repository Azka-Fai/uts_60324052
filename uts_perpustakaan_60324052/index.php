<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'config/database.php';
    
    $stmt = $conn->prepare("SELECT * FROM kategori ORDER BY id_kategori DESC");
    $stmt->execute();
    $result = $stmt->get_result();

    if(!$result){
        die("Query gagal: " . $conn->error);
    }
    ?>
    
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Kategori Buku</h2>
            <a href="create.php" class="btn btn-primary">Tambah Kategori</a>
        </div>
        
        <?php if(isset($_GET['msg'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_GET['msg']) ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th width="100">Kode</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th width="100">Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if($result->num_rows > 0){
                            $no = 1;
                            while($row = $result->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['kode_kategori']) ?></td>
                                <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                                <td>
                                    <?php if($row['status'] == 'Aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>

                                <a href="edit.php?id=<?= $row['id_kategori'] ?>" 
                                       class="btn btn-warning btn-sm">
                                       Edit
                                    </a>


                                    <button onclick="confirmDelete(<?= $row['id_kategori'] ?>)" 
                                            class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        <?php 
                            endwhile;
                        } else {
                        ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
    function confirmDelete(id) {
        if (confirm('Yakin ingin menghapus kategori ini?')) {
            window.location.href = 'delete.php?id=' + id;
        }
    }
    </script>
</body>
</html>