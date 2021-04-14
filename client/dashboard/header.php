<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Welcome to Bath & Bark</title>
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
    .modal-vertical-centered {
    transform: translate(0, 50%) !important;
    -ms-transform: translate(0, 50%) !important; /* IE 9 */
    -webkit-transform: translate(0, 50%) !important; /* Safari and Chrome */
    }
  </style>
  <style type="text/css">
    .swal2-popup {
      font-size: 1.6rem !important;
    }
  </style>
</head>

<body class="hold-transition skin-green sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
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
              <span class="hidden-xs"><?php echo 'Welcome, '.$_SESSION['dbg'].' '.$_SESSION['dbf'].' '.$_SESSION['dbl'].' ('.$_SESSION['dbcn'].')' ?></span>
            </a>
            <ul class="dropdown-menu">
             
              <!-- Menu Footer-->
              <li class="user-footer">
                
                <div >
                  <a href="<?php echo $baseurl; ?>client/dashboard/settings.php" class="btn btn-block btn-default btn-flat">User Settings</a>
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
        <li class="header">MAIN NAVIGATION</li>
        <li class="<?php if($pages == 'dashboard/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>client/dashboard"><i class="fa fa-calendar"></i> <span>My Appointments</span></a></li>
        <li class="treeview <?php if($pages == 'pet/index' || $pages == 'pet/add'){echo 'active'; } ?>">
          <a href="#">
            <i class="fa fa-paw"></i> <span>Manage Pets</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($pages == 'pet/add'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>client/dashboard/pets/add.php"><i class="fa fa-plus-circle"></i> Add Pet</a></li>
            <li class="<?php if($pages == 'pet/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>client/dashboard/pets"><i class="fa fa-list"></i> View Pets</a></li>
          </ul>
        </li>

        <li class="<?php if($pages == 'product/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>client/dashboard/products"><i class="fa fa-archive"></i> <span>Buy Products</span></a></li>


        <li class="<?php if($pages == 'product/cart'){echo 'active'; } ?>">
         <a href="<?php echo $baseurl; ?>client/dashboard/products/cart.php">
           <i class="fa fa-shopping-cart"></i> <span>Cart</span>
           <span id="cartcounter" class="pull-right-container">

            <?php 

              $sql = "SELECT COUNT(id) FROM tbl_client_cart WHERE order_code = '' AND client_id = ?";

              $qry = $connection->prepare($sql);
              $qry->bind_param('i',$_SESSION['dbu']);
              $qry->execute();
              $qry->bind_result($citems);
              $qry->store_result();
              $qry->fetch();
              
             ?>
             <small class="label pull-right bg-red"><?php if($citems != 0){echo $citems
;} ?></small>
            
           </span>
         </a>
       </li>

        <li class="<?php if($pages == 'order/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl; ?>client/dashboard/order/index.php"><i class="fa fa-file"></i> 
        <span>Order List

        <?php 

          $sql = "SELECT COUNT(id) FROM tbl_order WHERE client_id = ? AND status != 'Completed'";
          $qry = $connection->prepare($sql);
          $qry->bind_param('i',$_SESSION['dbu']);
          $qry->execute();
          $qry->bind_result($dbo);
          $qry->store_result();
          $qry->fetch();
          
         ?>
          <small class="label pull-right bg-red"><?php if($dbo != 0){echo $dbo
          ;} ?></small>


        </span></a></li>
       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>