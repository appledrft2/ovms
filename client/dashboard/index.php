<?php 
session_start();
include('../../includes/autoload.php');
if(isset($_POST['btnLogout'])){
  session_unset();
  header('location:'.$baseurl.'');
}
if(isset($_SESSION['dbu'])){ 
  if($_SESSION['dbc'] != true){
      header("location:".$baseurl."employee/dashboard");
  }
}else{
  header('location:'.$baseurl.'');
}
$pages = 'dashboard/index';
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
      <div class="box">
        <div class="row">
          <div class="col-md-6">
            <!-- THE CALENDAR -->
            <div id="calendar" style="width: 100%"></div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12"><h3>My Appointments</h3><br>
                      <button class="btn btn-primary">Request Schedule</button><br>
                         <table id="table4" class="table table-bordered table-hover">
                           <thead>
                           <tr>
                            <th>Type</th>
                             <th>Date of Appointment</th>
                             <th>Status</th>
                             <th>Details</th>
                           </tr>
                           </thead>
                           <tbody>
                           <tr>
                            <td>Follow Up</td>
                             <td>1/26/2021</td>
                             <td>Pending</td>
                             <td><button disabled class="btn btn-default fa fa-search"></button></td>
                           </tr>
                           <tr>
                             <td>Requested</td>
                             <td>1/22/2021</td>
                             <td>Completed</td>
                             <td><button class="btn btn-default fa fa-search"></button></td>
                           </tr>
                          </tbody>
                        </table> 
                      
                    </div>
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
<?php include('fullcalendar.php'); ?>