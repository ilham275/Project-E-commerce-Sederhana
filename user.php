<?php
session_start();
require_once 'config.php';

// Cek apakah user sudah login atau belum
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$id_user = $_SESSION['user_id'];


// Ambil data barang dari database
$sql = "SELECT * FROM barang where id_user = '$id_user'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$data_barang = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Memanggil header.php -->
<title>BARANG</title>
<?php require_once 'header.php'; ?>

<div class="container">
    <h2>Daftar Barang</h2>

    <div class="row mb-3">
        <div class="col-md-6">
            <a href="create.php" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Barang</a>
        </div>
        <div class="col-md-6 text-end">
            <!-- <a href="logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> Logout</a> -->
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data_barang as $barang) { ?>
                <tr>
                    <td><?php echo $barang['id_barang']; ?></td>
                    <td><?php echo $barang['nama_barang']; ?></td>
                    <td><?php echo $barang['stock']; ?></td>
                    <td><?php echo 'Rp ' . number_format($barang['harga'], 0, ',', '.'); ?></td>
                    <td><img src="img/<?php echo $barang['foto']; ?>" alt="<?php echo $barang['nama_barang']; ?>"></td>
                    <td>
                        <a href="edit.php?id=<?php echo $barang['id_barang']; ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                        <a href="delete.php?id=<?php echo $barang['id_barang']; ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Memanggil footer.php -->
<?php require_once 'footer.php'; ?>
