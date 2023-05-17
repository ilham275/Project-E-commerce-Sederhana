<?php
session_start();
include 'header.php';
include 'config.php';
$id_user = $_GET['id'];

    

            // update
            $query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $query->execute([$id_user]);
            $data = $query->fetch();
            $query = $pdo->prepare("SELECT * FROM detail WHERE id_user = ?");
            $query->execute([$id_user]);
            $detail = $query->fetch();
            $query = $pdo->prepare("SELECT * FROM profile WHERE id_user = ?");
            $query->execute([$id_user]);
            $foto = $query->fetch();
           
            

?>

<div class="container">
    
<table class="table">
					<tr>
						<th>ID USER</th>
						<td><?php if($data){
                            echo $data['id'];} ?></td>
					</tr>
					<tr>
						<th>USERNAME</th>
						<td><?php if($data){
                            echo $data['username'];} ?></td>
					</tr>
					<tr>
						<th>ROLE</th>
						<td><?php if($data){
                            echo $data['role'];} ?></td>
					</tr>
					<tr>
						<th>ALAMAT</th>
						<td><?php if($detail){
                            echo $detail['alamat'];} ?></td>
					</tr>
					<tr>
						<th>TELEPON</th>
						<td><?php if($detail){
                            echo $detail['tlpn'];} ?></td>
					</tr>
					<tr>
						<th>FOTO</th>
					
							<td>
                    <img src="img/<?= $foto['foto'] ?>" width="200"><br>
							</td>
					</tr>
			
				</table>
    
</div>

<?php include 'footer.php'; ?>
