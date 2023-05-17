<?php

session_start();
require_once "config.php";
$id_user = $_SESSION['user_id'];
 
// Query to select user data
$sql = "SELECT * FROM users where id != '$id_user'";
$result = $pdo->query($sql);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User</title>
    <!-- Include DataTable CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
</head>
<body>
<?php require_once 'headeradmin.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">User</h2>
                </div>
                <?php
                if($result->rowCount() > 0){
                    echo '<table id="user-table" class="table table-bordered table-striped">';
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Username</th>";
                                echo "<th>Action</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        $i = 1;
                        while($row = $result->fetch()){
                            echo "<tr>";
                                echo "<td>" . $i . "</td>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td>";
                                    echo '<a href="adminpass.php?id='. htmlspecialchars($row['id']) .'" class="btn btn-primary">Update Password</a>';
                                    echo '  ';
                                    echo '<a href="admindetail.php?id='. htmlspecialchars($row['id']) .'" class="btn btn-success">Detail</a>';
                                    echo '<a href="admindelete.php?id='. htmlspecialchars($row['id']) .'" class="btn btn-danger">delete</a>';
                                echo "</td>";
                            echo "</tr>";
                            $i++;
                        }
                        echo "</tbody>";                            
                    echo "</table>";
                    // Free result set
                    unset($result);
                } else{
                    echo "<p class='lead'><em>No records were found.</em></p>";
                }
                ?>
            </div>
        </div>        
    </div>
<?php require_once 'footer.php'; ?>
     
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     
    <!-- Include DataTable library -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
     
    <!-- Script to activate DataTable -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#user-table').DataTable();
        });
    </script>
</body>
</html>
