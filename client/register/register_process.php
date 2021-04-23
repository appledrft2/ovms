<?php 
session_start();
include('../../includes/autoload.php'); 
?> 
<?php 
  if(isset($_POST['btnRegister'])){
      $username = $_POST['username'];
      $sql = "SELECT username FROM tbl_user WHERE username=?";
      $qry = $connection->prepare($sql);
      $qry->bind_param('s', $username);
      $qry->execute();
      $qry->bind_result($dbusername);
      $qry->store_result();
      $qry->fetch();

      if($qry->num_rows() > 0){

        echo '<meta http-equiv="refresh" content="0; URL=index.php?status=duplicate">';

      }else{

        $client_num = "CID".rand(19999,29999);
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO tbl_client(firstname,middlename,lastname,username,gender,address,phone,password,client_num) VALUES(?,?,?,?,?,?,?,?,?)";
        $qry = $connection->prepare($sql);
        $qry->bind_param("sssssssss",$_POST['firstname'],$_POST['middlename'],$_POST['lastname'],$username,$_POST['gender'],$_POST['address'],$_POST['phone'],$hashed_password,$client_num);

        if($qry->execute()) {
        
          $role = "client";
          $sql2 = "INSERT INTO tbl_user(username,password,role) VALUES(?,?,?)";
          $qry2 = $connection->prepare($sql2);
          $qry2->bind_param("sss",$_POST['username'],$hashed_password,$role);
          $qry2->execute();

          header('location:index.php?status=created');

        }else{   
          echo '<meta http-equiv="refresh" content="0; URL=index.php?status=error">';
        }

      }
  }else{
    header('location:../index.php');
  }
?>