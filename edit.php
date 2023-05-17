<?php
// cek apakah user sudah login atau belum
session_start();
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// panggil file koneksi.php untuk menghubungkan ke database
require_once 'config.php';

// cek apakah data barang yang akan diupdate sudah dipilih atau belum
if (!isset($_GET['id'])) {
    header('Location: user.php');
    exit();
}

// ambil data barang yang akan diupdate dari database
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM barang WHERE id_barang=?");
$stmt->execute([$id]);
$barang = $stmt->fetch();

// cek apakah data barang yang akan diupdate ada di database atau tidak
if (!$barang) {
    header('Location: user.php');
    exit();
}

// jika tombol update ditekan, maka akan mengupdate data barang
if (isset($_POST['update'])) {
    $nama_barang = $_POST['nama_barang'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];
    $foto = $_FILES['foto'];

    // ambil nama file foto
    $nama_file = $foto['name'];

    // cek apakah ada file foto yang diupload
    if ($nama_file) {
        // tentukan lokasi folder untuk menyimpan foto
        $folder_foto = 'img/';

        // hapus foto lama jika ada
        if ($barang['foto']) {
            unlink($folder_foto . $barang['foto']);
        }

        // generate nama file foto baru dengan tambahan timestamp
        $nama_file_baru = time() . '_' . $nama_file;

        // pindahkan file foto yang diupload ke folder uploads
        move_uploaded_file($foto['tmp_name'], $folder_foto . $nama_file_baru);
    } else {
        // gunakan foto lama jika tidak ada foto yang diupload
        $nama_file_baru = $barang['foto'];
    }

    // update data barang ke database
    $stmt = $pdo->prepare("UPDATE barang SET nama_barang=?, stock=?, harga=?, foto=? WHERE id_barang=?");
    $stmt->execute([$nama_barang, $stock, $harga, $nama_file_baru, $id]);

    // redirect ke halaman user setelah data barang berhasil diupdate
    header('Location: user.php');
    exit();
}
?>

<div class="container">
    <div class="col-md-6 offset-md-3">
    <h1>Edit Barang</h1>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="<?= $barang['nama_barang'] ?>">
        </div>

        <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" value="<?= $barang['stock'] ?>">
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" value="<?= $barang['harga'] ?>">
        </div>
      
        <label>Foto:</label><br>
        <img src="img/<?= $barang['foto'] ?>" width="200"><br>
        <input type="file" name="foto"><br><br>

        <input type="submit" name="update" value="Update">
    </form>
        </div>
    </div>



    <?php include 'footer.php'; ?>

