<?php 
session_start();
include('../includes/autoload.php'); 
?> 
<?php

      if(isset($_POST['btnLogin'])){
          $username = $_POST['email-id'];
          $password = $_POST['password'];
          function checkEmail($email) {
             $find1 = strpos($email, '@');
             $find2 = strpos($email, '.');
             return ($find1 !== false && $find2 !== false && $find2 > $find1);
          }
          if(checkEmail($username)){
            $sql = "SELECT id,firstname,lastname,gender FROM tbl_client WHERE email=? AND password=?";
          }else{
            $sql = "SELECT id,firstname,lastname,gender FROM tbl_client WHERE client_num=? AND password=?";
          }
          
          $qry = $connection->prepare($sql);
          $qry->bind_param('ss', $username,$password);
          $qry->execute();
          $qry->bind_result($id,$dbf,$dbl,$dbg);
          $qry->store_result();
          $qry->fetch();
          if($qry->num_rows() == 0) {

             header('location:index.php?error=true');

          }else {
            
              $_SESSION['dbu'] = $id;
              $_SESSION['dbf'] = $dbf;
              $_SESSION['dbl'] = $dbl;
              $_SESSION['dbc'] = true;
              $dbg = ($dbg == 'Male') ? 'Mr.' : "Ms.";
              $_SESSION['dbg'] = $dbg;
              header('location:'.$baseurl.'client/dashboard/');
           
          }
        }
    ?>