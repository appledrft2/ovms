<?php 
session_start();
include('../includes/autoload.php'); 
?> 
<?php

    if(isset($_POST['btnLogin'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT id,firstname,lastname,gender,password,employee_type FROM tbl_employee WHERE username=?";
    
        $qry = $connection->prepare($sql);
        $qry->bind_param('s', $username);
        $qry->execute();
        $qry->bind_result($id,$dbf,$dbl,$dbg,$dbp,$dbet);
        $qry->store_result();
        $qry->fetch();

        if($qry->num_rows() > 0) {
          
            if(password_verify($password, $dbp)){
              $_SESSION['dbu'] = $id;
              $_SESSION['dbf'] = $dbf;
              $_SESSION['dbl'] = $dbl;
              $_SESSION['dbet'] = $dbet;
              // dbc = false - employee side access only - cannot login to client
              $_SESSION['dbc'] = false;
              $dbg = ($dbg == 'Male') ? 'Mr.' : "Ms.";
              $_SESSION['dbg'] = $dbg;
              header('location:'.$baseurl.'employee/dashboard/');
            }else{
              header('location:index.php?error=true');
            }

        }else{
          header('location:index.php?error=true');
        }
    }
?>