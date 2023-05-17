<?php
// cek apakah user sudah login atau belum
session_start();
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$id_user = $_SESSION['user_id'];


// panggil file koneksi.php untuk menghubungkan ke database
require_once 'config.php';

// cek apakah data barang yang akan diupdate sudah dipilih atau belum
if (!isset($_GET['id'])) {
    header('Location: user.php');
    exit();
}

// ambil data barang yang akan diupdate dari database
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM barang WHERE id_barang='$id'");
$stmt->execute();
$barang = $stmt->fetch();
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id='$id_user'");
$stmt->execute();
$data = $stmt->fetch();




// cek apakah data barang yang akan diupdate ada di database atau tidak
if (!$barang) {
    header('Location: user.php');
    exit();
}
if (isset($_POST['submit'])) {
    $id_barang = $barang['id_barang'];
    $qty = $_POST['qty'];
    $harga = $barang['harga'];
    $total_harga = $qty * $harga;
    $total = $total_harga;
    $stmt = $pdo->prepare("INSERT INTO pembelian (id_barang, id_user, qty, total) VALUES ( ?, ?, ?, ?)");
    $stmt->execute([$id_barang, $id_user, $qty, $total]);
    $id_pembelian = $pdo->lastInsertId();
    $stock_akhir =$barang['stock'] - $qty;

    $test = $pdo->prepare("UPDATE barang SET stock=? WHERE id_barang=?");
    $test->execute([$stock_akhir, $id_barang]);

    //log
    $activty = "Melakukan Pembelian Dengan ID Barang : ". $id_pembelian;
    $log = $pdo->prepare("INSERT INTO log (id_user, activity) VALUES (?, ?)");
    $log->execute([$id_user, $activty]);

    
    if($data['role'] == 'user')
    {
        header("Location: user.php");
        exit();
    }
    else
    {
        header("Location: admin.php");
        exit();
    }

}






?>

<div class="container">
    <div class="col-md-6 offset-md-3">

    <table class="table">
					<tr>
						<th>Nama Barang</th>
						<td><?php echo $barang['nama_barang']; ?></td>
					</tr>
					<tr>
                        <th>Foto</th>
                        <td><img src="img/<?php echo $barang['foto']; ?>" alt="<?php echo $barang['nama_barang']; ?>"></td>
                        
					</tr>
                    <tr>
                        <th>Stock Tersedia</th>
                        <td><?php echo $barang['stock']; ?></td>
                    </tr>
					<tr>
						<th>Harga</th>
                    <td><?php echo 'Rp ' . number_format($barang['harga'], 0, ',', '.'); ?></td>

					</tr>
					
				</table>
    <h1>Pembelian</h1>

    <form method="post" enctype="multipart/form-data">
        <!-- <div class="mb-3">
                    <label for="stock" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="<?= $barang['nama_barang'] ?>">
        </div>

        <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" value="<?= $barang['stock'] ?>">
        </div> -->
        <div class="mb-3">
            <label for="qty" class="form-label">Quantity</label>
            <input type="number" name="qty" id="qty" class="form-control">
        </div>
      
     
        <input type="submit" name="submit" value="Submit">
    </form>
        </div>
    </div>



    <?php include 'footer.php'; ?>

