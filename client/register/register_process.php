<?php 
session_start();
include('../../includes/autoload.php'); 
?> 
<?php 
  if(isset($_POST['btnRegister'])){
      $client_num = "CID".rand(19999,29999);
      $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $sql = "INSERT INTO tbl_client(firstname,middlename,lastname,email,gender,address,phone,password,client_num) VALUES(?,?,?,?,?,?,?,?,?)";
      $qry = $connection->prepare($sql);
      $qry->bind_param("sssssssss",$_POST['firstname'],$_POST['middlename'],$_POST['lastname'],$_POST['email'],$_POST['gender'],$_POST['address'],$_POST['phone'],$hashed_password,$client_num);

      if($qry->execute()) {
        echo '<meta http-equiv="refresh" content="0; URL=index.php?status=created&cid='.$client_num.'">';
      }else{   
        echo '<meta http-equiv="refresh" content="0; URL=index.php?status=error">';
      }
  }
?>