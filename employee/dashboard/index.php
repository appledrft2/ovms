<?php 
session_start();
include('../../includes/autoload.php');
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != false){
      header("location:".$baseurl."client/dashboard");
  }
}else{
  header('location:'.$baseurl.'');
}

include('sales_income.php');
include('order_income.php');
include('appointment_income.php');




$pages ='dashboard/index';
?>
<?php include('header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Overview</span>

          </h1>
          <h2 class="col-md-6 text-right">
            <span class="text-right"><i class="fa fa-calendar"></i> <?php echo date('D, M. d Y') ?></span>
          </h2>
        </div>
      </section>

    <!-- Main content -->
    <section class="content">
      <?php if($_SESSION['dbet'] == 'Admin'){ ?>  


     
      <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-green">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Daily Sales Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($today + $o_today,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-red">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Weekly Sales Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($week + $o_week,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
               <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-default">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Monthly Sales Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($month + $o_month,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-blue">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Annual Sales Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($year + $o_year,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->

      </div>
      <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-green">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Daily Service Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($a_today,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-red">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Weekly Service Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($a_week,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
               <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-default">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Monthly Service Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($a_month,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-blue">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Annual Service Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($a_year,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->

      </div>
      <?php }else{ ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <p><i class="icon fa fa-dashboard"></i>Welcome Back, <?php echo $_SESSION['dbg'].''.ucwords($_SESSION['dbl']); ?>!</p>
         
        </div>
      <?php if($_SESSION['dbet'] == 'Veterinarian'):?>
      <?php include('ap_vet_income.php') ?>
      <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-green">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Daily Service Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($v_today,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-red">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Weekly Service Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($v_week,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
               <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-default">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Monthly Service Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($v_month,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-blue">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Annual Service Income</span>
                    <span class="info-box-number">&#8369; <?php echo number_format($v_year,2);  ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
      </div>
      <?php endif ?>
      

      <?php } ?>

      <div class="row">
        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-body">
              <p class="h2" style="padding:0 10px;">Mission, Vision and Values</p>
              <p class="text-justify" style="font-size: 1.2em;padding:0 10px">We have come together as a staff to decide why and how we do what we do.  When taking care of our clients and patients we are guided by this vision which is further defined by our clinic’s core values, our mission and our philosophies.   We then use these as a guide to help us better in our daily interactions.</p>
            </div>
          </div>


        </div>

        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header">
              <h2>Client Schedule</h2>
            </div>
            <div class="box-body no-padding ">
              <style>
                 .fc-day-grid-event .fc-content {
                   white-space: normal; 
                   text-align: center;
                }
              </style>
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
      </div>
      
    </section>

  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2020-2021 <a href="#">Bath & Bark Grooming and Veterinary Services Management System</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<?php include('footer.php') ?>

