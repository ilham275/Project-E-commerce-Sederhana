<?php
session_start();
include 'header.php';
include 'config.php';


$id_user = $_SESSION['user_id'];

            if (isset($_POST['submit'])) {
                $id_user = $_SESSION['user_id'];
                $foto = $_FILES['foto']['name'];
                $tmp = $_FILES['foto']['tmp_name'];
                $folder = "img/";
            
                move_uploaded_file($tmp, $folder.$foto);
            
                $stmt = $pdo->prepare("INSERT INTO profile (id_user, foto) VALUES (?, ?)");
                $stmt->execute([$id_user, $foto]);
            
                header("Location: userall.php");
                exit();
            }

            // update
            $query = $pdo->prepare("SELECT * FROM profile WHERE id_user = ?");
            $query->execute([$id_user]);
            $data = $query->fetch();
            if (isset($_POST['update'])) {
            $foto = $_FILES['foto'];
            $nama_file = $foto['name'];
            if ($nama_file) {
                // tentukan lokasi folder untuk menyimpan foto
                $folder_foto = 'img/';
        
                // hapus foto lama jika ada
                if ($data['foto']) {
                    unlink($folder_foto . $data['foto']);
                }
        
                // generate nama file foto baru dengan tambahan timestamp
                $nama_file_baru = time() . '_' . $nama_file;
        
                // pindahkan file foto yang diupload ke folder uploads
                move_uploaded_file($foto['tmp_name'], $folder_foto . $nama_file_baru);
            } else {
                // gunakan foto lama jika tidak ada foto yang diupload
                $nama_file_baru = $data['foto'];
            }
            $stmt = $pdo->prepare("UPDATE profile SET foto=? WHERE id_user=?");
            $stmt->execute([$nama_file_baru, $id_user]);

            // redirect ke halaman user setelah data barang berhasil diupdate
            header('Location: user.php');
            exit();

            }

            

?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="mb-4">Foto</h2>
            <form method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <img src="img/<?= $data['foto'] ?>" width="200"><br>
                    <input type="file" name="foto" id="foto" accept="image/*" class="form-control" required>
                </div>
                <div class="mb-3">
                    <?php
                    if($data) {
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
