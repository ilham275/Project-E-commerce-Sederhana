<?php
session_start();
include 'header.php';
include 'config.php';
$id_user = $_SESSION['user_id'];

            if (isset($_POST['submit'])) {
                $id_user = $_SESSION['user_id'];
                $alamat = $_POST['alamat'];
                $tlpn = $_POST['tlpn'];
            
                move_uploaded_file($tmp, $folder.$foto);
            
                $stmt = $pdo->prepare("INSERT INTO detail (id_user, alamat, tlpn) VALUES ( ?, ?, ?)");
                $stmt->execute([$id_user, $alamat, $tlpn]);
            
                header("Location: userall.php");
                exit();
            }

            // update
            $query = $pdo->prepare("SELECT * FROM detail WHERE id_user = ?");
            $query->execute([$id_user]);
            $data = $query->fetch();
            if (isset($_POST['update'])) {
            $alamat = $_POST['alamat'];
            $tlpn = $_POST['tlpn'];
                    
            $stmt = $pdo->prepare("UPDATE detail SET alamat=?, tlpn=? WHERE id_user=?");
            $stmt->execute([$alamat, $tlpn, $id_user]);
            header('Location: userall.php');
            exit();
            }
            

?>

<div class="container">
    
<table class="table">
					<tr>
						<th>ID User</th>
						<td><?php if($data){
                            echo $data['id_user'];} ?></td>
					</tr>
					<tr>
						<th>Alamat</th>
						<td><?php if($data){
                            echo $data['alamat'];} ?></td>
					</tr>
					<tr>
						<th>Telepon</th>
						<td><?php if($data){
                            echo $data['tlpn'];} ?></td>
					</tr>
			
				</table>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="mb-4">Lengkapi Data Profile</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" <?php if($data){echo'value='.'"'.$data['alamat'].'"';}?>required>
                </div>
                <div class="mb-3">
                    <label for="tlpn" class="form-label">Nomor Telepon</label>
                    <input type="number" name="tlpn" id="tlpn" class="form-control" <?php if($data){echo'value='.'"'.$data['tlpn'].'"';}?>required>
                </div>
              
                <div class="mb-3">
                    <?php
                    if($data){
                        echo'<button type="submit" name="update" class="btn btn-primary">Update</button>';
                    }
                    else{
                        echo'<button type="submit" name="submit" class="btn btn-primary">Simpan</button>';
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
