<?php 
session_start();
include('../includes/autoload.php'); 
?> 
<?php

      if(isset($_POST['btnLogin'])){
          $username = $_POST['username'];
          $password = $_POST['password'];


            $sql = "SELECT id,firstname,lastname,gender,password,phone,client_num FROM tbl_client WHERE username=? OR  client_num=?";

          
          $qry = $connection->prepare($sql);
          $qry->bind_param('ss', $username, $username);
          $qry->execute();
          $qry->bind_result($id,$dbf,$dbl,$dbg,$dbp,$dbphone,$dbcn);
          $qry->store_result();
          $qry->fetch();

          if($qry->num_rows() > 0) {
            if(password_verify($password, $dbp)){
              $_SESSION['dbu'] = $id;
              $_SESSION['dbf'] = $dbf;
              $_SESSION['dbl'] = $dbl;
              $_SESSION['dbphone'] = $dbphone;
              $_SESSION['dbcn'] = $dbcn;
              // dbc = true - client side access only - cannot login to employee
              $_SESSION['dbc'] = true;
              $dbg = ($dbg == 'Male') ? 'Mr.' : "Ms.";
              $_SESSION['dbg'] = $dbg;
              header('location:'.$baseurl.'client/dashboard/');
            }else{
              header('location:index.php?error=true');
            }
        }else{
          header('location:index.php?error=true');
        }
    }
?>