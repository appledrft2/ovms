<?php
session_start();
include('includes/autoload.php');
?>
<?php

    if(isset($_POST['btnLogin'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT username,password,role FROM tbl_user WHERE username=? AND status='Activated'";
        $qry = $connection->prepare($sql);
        $qry->bind_param('s', $username);
        $qry->execute();
        $qry->bind_result($dbusername,$dbpassword,$dbrole);
        $qry->store_result();
        $qry->fetch();

        if($qry->num_rows() > 0) {

           if(password_verify($password, $dbpassword)){

              if($dbrole == 'Admin' || $dbrole == "Veterinarian" || $dbrole == "Secretary"){
                // dbc = false - employee side access only - cannot login to client
                $_SESSION['dbc'] = false;

                $sql2 = "SELECT id,firstname,lastname,gender,password,employee_type FROM tbl_employee WHERE username=?";
                $qry2 = $connection->prepare($sql2);
                $qry2->bind_param('s', $username);
                $qry2->execute();
                $qry2->bind_result($id,$dbf,$dbl,$dbg,$dbp,$dbet);
                $qry2->store_result();
                $qry2->fetch();

                $_SESSION['dbu'] = $id;
                $_SESSION['dbf'] = $dbf;
                $_SESSION['dbl'] = $dbl;
                $_SESSION['dbet'] = $dbet;
                $dbg = ($dbg == 'Male') ? 'Mr.' : "Ms.";
                $_SESSION['dbg'] = $dbg;

                $activity = "Logged in Successfully.";
                $sqlx = "INSERT INTO tbl_logs(employee_id,activity) VALUES(?,?)";
                $qryx = $connection->prepare($sqlx);
                $qryx->bind_param("is",$id,$activity);
                $qryx->execute();


                header('location:'.$baseurl.'employee/dashboard/');
              }else{
                // dbc = true - client side access only - cannot login to employee
                $_SESSION['dbc'] = true;

                $sql = "SELECT id,firstname,lastname,gender,password,phone,client_num FROM tbl_client WHERE username=?";
                $qry = $connection->prepare($sql);
                $qry->bind_param('s', $username);
                $qry->execute();
                $qry->bind_result($id,$dbf,$dbl,$dbg,$dbp,$dbphone,$dbcn);
                $qry->store_result();
                $qry->fetch();

                $_SESSION['dbu'] = $id;
                $_SESSION['dbf'] = $dbf;
                $_SESSION['dbl'] = $dbl;
                $_SESSION['dbphone'] = $dbphone;
                $_SESSION['dbcn'] = $dbcn;
                $dbg = ($dbg == 'Male') ? 'Mr.' : "Ms.";
                $_SESSION['dbg'] = $dbg;

                header('location:'.$baseurl.'client/dashboard/');
              }
            }else{
              header('location:login.php?error=true');
            }

        }
        else{
          header('location:login.php?error=true');
        }
    }
?>
