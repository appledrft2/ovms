<?php
  session_start();
    if(empty(isset($_SESSION['dbu']))){
        header("location:../");
    }
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
                    <div class="col-md-12"><br>
                      <button class="btn btn-primary">Request Schedule</button>

                       <table id="table2" class="table table-bordered table-hover">
                         <thead>
                         <tr>
                           <th>Date Requested</th>
                           <th>Date of Appointment</th>
                           <th>Status</th>
                         </tr>
                         </thead>
                         <tbody>
                         <tr>
                           <td>1/19/2021</td>
                           <td>-</td>
                           <td>Pending</td>
                         </tr>
                        </tbody>
                      </table> 
                    </div>
                     <div class="col-md-12">
                      <b>Follow Up Checkup</b>
                         <table id="table3" class="table table-bordered table-hover">
                           <thead>
                           <tr>
                             <th>Date of Appointment</th>
                             <th>Status</th>
                             <th>Action</th>
                           </tr>
                           </thead>
                           <tbody>
                           <tr>
                             <td>1/26/2021</td>
                             <td>Completed</td>
                             <td><button class="btn btn-default fa fa-file"></button></td>
                           </tr>
                          </tbody>
                        </table> 
                      
                    </div>
                    <div class="col-md-12">
                      <b>Past Appointments</b>
                         <table id="table4" class="table table-bordered table-hover">
                           <thead>
                           <tr>
                            <th>Type</th>
                             <th>Date of Appointment</th>
                             <th>Status</th>
                             <th>Action</th>
                           </tr>
                           </thead>
                           <tbody>
                           <tr>
                            <td>Follow Up</td>
                             <td>1/26/2021</td>
                             <td>Completed</td>
                             <td><button class="btn btn-default fa fa-file"></button></td>
                           </tr>
                           <tr>
                             <td>Requested</td>
                             <td>1/22/2021</td>
                             <td>Completed</td>
                             <td><button class="btn btn-default fa fa-file"></button></td>
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