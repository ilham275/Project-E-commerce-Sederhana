<?php
session_start();
include 'header.php';
include 'config.php';

            if (isset($_POST['submit'])) {
                $id_user = $_SESSION['user_id'];
                $nama_barang = $_POST['nama_barang'];
                $stock = $_POST['stock'];
                $harga = $_POST['harga'];
            
                $foto = $_FILES['foto']['name'];
                $tmp = $_FILES['foto']['tmp_name'];
                $folder = "img/";
            
                move_uploaded_file($tmp, $folder.$foto);
            
                $stmt = $pdo->prepare("INSERT INTO barang (id_user, nama_barang, stock, harga, foto) VALUES ( ?, ?, ?, ?, ?)");
                $stmt->execute([$id_user, $nama_barang, $stock, $harga, $foto]);
            
                header("Location: user.php");
                exit();
            }
            

?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="mb-4">Tambah Barang</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" name="harga" id="harga" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" id="foto" accept="image/*" class="form-control" required>
                </div>
                <div class="mb-3">
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
