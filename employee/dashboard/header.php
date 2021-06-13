<?php
if(isset($_POST['btnLogout'])){
  $activity = "Logged Out Successfully.";
  $sqlx = "INSERT INTO tbl_logs(employee_id,activity) VALUES(?,?)";
  $qryx = $connection->prepare($sqlx);
  $qryx->bind_param("is",$_SESSION['dbu'],$activity);
  $qryx->execute();

  session_unset();

  header('location:'.$baseurl.'');
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard | Bath & Bark</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/dist/css/skins/_all-skins.min.css">
  <!-- Pace style -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/plugins/pace/pace.min.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="icon" type="image/png" href="<?php echo $baseurl ?>/logo.jpg"/>

    <!-- fullCalendar -->
  <link rel="stylesheet" href="<?php echo $baseurl; ?>template/bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="<?php echo $baseurl; ?>template/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">

    .sidebarblue{
      background-color: #1295ad !important;
    }.sidebarblue:hover{
      background-color: #1295ad !important;
    }

    @media print {
      #printPageButton {
        display: none;
      }
    }
    .swal2-popup {
      font-size: 1.6rem !important;
    }
    .modal {
      text-align: center;
    }

    @media screen and (min-width: 768px) {
      .modal:before {
        display: inline-block;
        vertical-align: middle;
        content: " ";
        height: 100%;
      }
    }

    .modal-dialog {
      display: inline-block;
      text-align: left;
      vertical-align: middle;
    }
  </style>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo $baseurl; ?>template/bower_components/select2/dist/css/select2.min.css">

</head>

<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo sidebarblue">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>V</b>MS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">Bath & Bark - <b>V</b>MS</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs"><?php echo 'Welcome, '.$_SESSION['dbg'].' '.$_SESSION['dbl'].' ('.$_SESSION['dbet'].')' ?></span>
            </a>
            <ul class="dropdown-menu">

              <!-- Menu Footer-->
              <li class="user-footer">

                <div >
                  <a href="<?php echo $baseurl; ?>employee/dashboard/settings.php" class="btn btn-block btn-default btn-flat">User Settings</a>

                  <form method="POST" action="#">
                      <button name="btnLogout" class="btn btn-block btn-default btn-flat">Sign out</button>
                  </form>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header text-center">MAIN NAVIGATION</li>
        <li class="<?php if($pages == 'dashboard/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

        <li class="<?php if($pages == 'appointment/schedule'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/schedule"><i class="fa fa-calendar-check-o"></i> <span>Doctor Schedule</span></a></li>

        <li class="<?php if($pages == 'appointment/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/appointments"><i class="fa fa-calendar"></i> <span>Appointments</span></a></li>



        <li class="treeview <?php if($pages == 'service/index' || $pages == 'service/add'){echo 'active'; } ?>">
          <a href="#">
            <i class="fa fa-heart"></i> <span>Services</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="<?php if($pages == 'service/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/services"><i class="fa fa-list-alt"></i> View Services</a></li>
          </ul>
        </li>
        <?php if($_SESSION['dbet'] == 'Admin'){ ?>

         <li class="treeview <?php if($pages == 'employee/index' || $pages == 'employee/add'){echo 'active'; } ?>">
           <a href="#">
             <i class="fa fa-users"></i> <span>Employee</span>
             <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
             </span>
           </a>
           <ul class="treeview-menu">

             <li class="<?php if($pages == 'employee/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/employees"><i class="fa fa-list-alt"></i> View Employees</a></li>
           </ul>
         </li>

         <li class="treeview <?php if($pages == 'client/index' || $pages == 'client/add'){echo 'active'; } ?>">
           <a href="#">
             <i class="fa fa-users"></i> <span>Client</span>
             <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
             </span>
           </a>
           <ul class="treeview-menu">

             <li class="<?php if($pages == 'client/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/client"><i class="fa fa-list-alt"></i> View Client</a></li>
           </ul>
         </li>

        <?php } ?>


       <!--  <li class="<?php if($pages == 'appointment/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/appointment"><i class="fa fa-calendar"></i> <span>Completed Appointments</span></a></li>
        <li class="<?php if($pages == 'crecord/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/crecords"><i class="fa fa-book"></i> <span>View Client Records</span></a></li> -->
         <li class="header text-center">INVENTORY</li>
         <li class="treeview <?php if($pages == 'pcategory/index'|| $pages == 'pcategory/add'){echo 'active'; } ?>">
           <a href="#">
             <i class="fa fa-tag"></i> <span>Product Category</span>
             <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
             </span>
           </a>
           <ul class="treeview-menu">

             <li class="<?php if($pages == 'pcategory/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/pcategory"><i class="fa fa-list-alt"></i> View Categories</a></li>
           </ul>
         </li>
         <li class="treeview <?php if($pages == 'punit/index'|| $pages == 'punit/add'){echo 'active'; } ?>">
           <a href="#">
             <i class="fa fa-balance-scale"></i> <span>Product Unit</span>
             <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
             </span>
           </a>
           <ul class="treeview-menu">

             <li class="<?php if($pages == 'punit/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/punit"><i class="fa fa-list-alt"></i> View Unit</a></li>
           </ul>
         </li>
        <li class="treeview <?php if($pages == 'product/index'|| $pages == 'product/add'){echo 'active'; } ?>">
          <a href="#">
            <i class="fa fa-archive"></i> <span>Products</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="<?php if($pages == 'product/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/products"><i class="fa fa-list-alt"></i> View Products</a></li>
          </ul>
        </li>
         <li class="treeview <?php if($pages == 'receiving/index'|| $pages == 'receiving/add'){echo 'active'; } ?>">
           <a href="#">
             <i class="fa fa-truck"></i> <span>Receiving</span>
             <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
             </span>
           </a>
           <ul class="treeview-menu">

             <li class="<?php if($pages == 'receiving/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/receiving"><i class="fa fa-list-alt"></i> Stock In List</a></li>
           </ul>
         </li>
         <li class="<?php if($pages == 'pos/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/pos"><i class="fa fa-shopping-cart"></i> <span>Point of Sales</span></a></li>


         <?php if($_SESSION['dbet'] == 'Admin'){ ?>
         <li class="treeview <?php if($pages == 'reports/index'|| $pages == 'service_reports/index'){echo 'active'; } ?>">
           <a href="#">
             <i class="fa fa-file"></i> <span>Reports</span>
             <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
             </span>
           </a>
           <ul class="treeview-menu">
             <li class="<?php if($pages == 'reports/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/reports/index.php"><i class="fa fa-file"></i> Sales Report</a></li>
             <li class="<?php if($pages == 'service_reports/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/service_reports/index.php"><i class="fa fa-file"></i> Service Report</a></li>

           </ul>
         </li>
        <?php } ?>

        <?php if($_SESSION['dbet'] == 'Admin'){ ?>
        <li class="<?php if($pages == 'order/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/order"><i class="fa fa-gavel"></i> <span>Orders</span></a></li>

        <?php } ?>



         <?php if($_SESSION['dbet'] == 'Admin'){ ?>
          <li class="header text-center">SETTINGS</li>


          <li class="treeview <?php if($pages == 'system/index' || $pages == 'system/add'){echo 'active'; } ?>">
            <a href="#">
              <i class="fa fa-pencil"></i> <span>System Logs</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if($pages == 'system/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/logs"><i class="fa fa-list-alt"></i> View Logs</a></li>
            </ul>
          </li>

          <li class="<?php if($pages == 'order/settings'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>employee/dashboard/order/settings.php"><i class="fa fa-cog"></i> <span>Order Settings</span></a></li>
         <?php } ?>



      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
