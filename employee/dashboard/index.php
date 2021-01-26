<?php 
session_start();
include('../../includes/autoload.php');
if(isset($_POST['btnLogout'])){
  session_unset();
  header('location:'.$baseurl.'');
}
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != false){
      header("location:".$baseurl."client/dashboard");
  }
}else{
  header('location:'.$baseurl.'');
}
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
      <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-green">&#8369;</span>

                  <div class="info-box-content">
                    <span class="info-box-text">Daily Income</span>
                    <span class="info-box-number">&#8369; 0.00</span>
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
                    <span class="info-box-text">Weekly Income</span>
                    <span class="info-box-number">&#8369; 0.00</span>
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
                    <span class="info-box-text">Monthly Income</span>
                    <span class="info-box-number">&#8369; 0.00</span>
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
                    <span class="info-box-text">Annual Income</span>
                    <span class="info-box-number">&#8369; 0.00</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->

      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <label>Upcomming Appointments</label>
            </div>
            <div class="box-body">
              <table id="table1" class="table">
                <thead>
                  <tr>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Date of Appointment</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Ragie Doromal</td>
                    <td>Requested</td>
                    <td>1/27/2021</td>
                    <td>Approved</td>
                    <td><button class="btn btn-default"><i class="fa fa-list"></i></button></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <label>Appointment Request</label>
            </div>
            <div class="box-body">
              <table id="table11" class="table">
                <thead>
                  <tr>
                    <th>Client</th>
                    <th>Date Requested</th>
                    <th>Date of Appoinment</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Maria Santos</td>
                    <td>1/22/2021</td>
                    <td>1/30/2021</td>
                    <td>Pending</td>
                    <td><button class="btn btn-default"><i class="fa fa-list"></i></button></td>
                  </tr>
                  <tr>
                    <td>Ragie Doromal</td>
                    <td>1/20/2021</td>
                    <td>1/27/2021</td>
                    <td>Approved</td>
                    <td><button class="btn btn-default"><i class="fa fa-list"></i></button></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
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
