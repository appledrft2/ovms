<?php 
session_start();
include('../includes/autoload.php'); 
?> 
<?php

      if(isset($_POST['btnLogin'])){
          $username = $_POST['email-id'];
          $password = $_POST['password'];

          // condition for checking email or id number
          function checkEmail($email) {
             $find1 = strpos($email, '@');
             $find2 = strpos($email, '.');
             return ($find1 !== false && $find2 !== false && $find2 > $find1);
          }
          if(checkEmail($username)){
            $sql = "SELECT id,firstname,lastname,gender,password,phone FROM tbl_client WHERE email=?";
          }else{
            $sql = "SELECT id,firstname,lastname,gender,password,phone FROM tbl_client WHERE client_num=?";
          }
          
          $qry = $connection->prepare($sql);
          $qry->bind_param('s', $username);
          $qry->execute();
          $qry->bind_result($id,$dbf,$dbl,$dbg,$dbp,$dbphone);
          $qry->store_result();
          $qry->fetch();

          if($qry->num_rows() > 0) {
            if(password_verify($password, $dbp)){
              $_SESSION['dbu'] = $id;
              $_SESSION['dbf'] = $dbf;
              $_SESSION['dbl'] = $dbl;
              $_SESSION['dbphone'] = $dbphone;
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