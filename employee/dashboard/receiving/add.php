<?php 
session_start();
include('../../../includes/autoload.php');
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
$pages ='receiving/index';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Stock In</span>

          </h1>
          <h2 class="col-md-6 text-right">
            <span class="text-right"><i class="fa fa-calendar"></i> <?php echo date('D, M. d Y') ?></span>
          </h2>
        </div>
      </section>

    <!-- Main content -->
    <section class="content">
      <form id="form1" method="POST" action="#">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header">

                <div class="row">
                  <div class="col-md-6">
                    <label>Delivery #: <i style="color:red">*</i></label>
                    <input type="text" class="form-control dcode" value="DC<?php echo rand(199999,299999); ?>" name="dcode" required readonly>
                    
                    <label>Supplier Name: <i style="color:red">*</i></label>
                    <input type="text" class="form-control supplier" name="supplier" required>
                    
                   
                  </div>
                  <div class="col-md-6">
                    <label>Delivery Date: <i style="color:red">*</i></label>
                    <input type="date" class="form-control ddate" name="ddate" required>
                   
                  </div>
                 
                </div>
              </div>
              <div class="box-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Product name</th>
                      <!-- <th>Update Supplier Price</th> -->
                      <th>Update Price</th>
                      <th>Qty to Add</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="tblprod">
                    <tr>
                      <td>
                        <select type="text" class="form-control selectprod select2" name="prodid[]" style="width: 100%;" required>
                          <option selected disabled value="">Select Product</option>
                           <?php 
                            $sql = "SELECT id,name,category,unit,original,selling,quantity,status,timestamp FROM tbl_product ORDER BY timestamp ASC";
                            $qry = $connection->prepare($sql);
                            $qry->execute();
                            $qry->bind_result($id,$dbn, $dbc, $dbu,$dbo,$dbs,$dbq,$dbst,$dbtimestamp);
                            $qry->store_result();
                            while($qry->fetch ()) {
                              echo '
                                <option value="'.$id.'">'.$dbn.'</option>
                               ';
                            }
                          ?>
                        </select>
                      </td>
             
                      
                   <!--    <td><input type="number" style="display:none" class="form-control origprice" name="original[]" placeholder="&#8369;0.00" required ></td> -->
                      <td><input type="number" class="form-control sellprice" name="selling[]" placeholder="&#8369;0.00" required ></td>
                      <td><input type="number" class="form-control quantity" name="quantity[]" placeholder="Enter Quantity" required ></td>
                      <td><button type="button" class="btn btn-danger btn-sm" disabled><i class="fa fa-remove"></i></button></td>
                    </tr>
                  </tbody>
                  <tfoot>
                      <tr>
                        <td colspan="9"><button id="moreprod" type="button" class="pull-right btn btn-success btn-sm"><i class="fa fa-plus-circle"></i>&nbsp;Add more</button></td>
                      </tr>
                    </tfoot>
                </table>
              </div>
              <div class="box-footer">
                <div class="pull-right">
                  <a href="<?php echo $baseurl; ?>employee/dashboard/receiving" class="btn btn-default" > Go Back</a>
                  <button type="submit" name="btnSave" class="btn btn-success"> Confirm Delivery</button>
                </div>  
              </div>
            </div>
          </div>
        </div>
      </form>
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
<script src="<?php echo $baseurl ?>template/plugins/sweetalert2.all.min.js"></script>
<!-- Select2 -->
<script src="<?php echo $baseurl ?>template/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
      $('.select2').select2();
  });

  $(document).on('change','.selectprod',function(){
      var prodid = $(this).val();
      var proddata = null;
      $.ajax({
        async: false,
        global: false,
        url:'get_product.php',
        method:'POST',
        data:{
            prodid:prodid
        },
       success:function(data){
        data = JSON.parse(data);
        proddata = data;
       }
    });
  
      $(this).closest('tr').find('.origprice').val(proddata[1]);
      $(this).closest('tr').find('.sellprice').val(proddata[2]);
      $(this).closest('tr').find('.quantity').val(1);

  });

  $('#moreprod').click(function(){
    $("#tblprod").append('<tr> <td> <select type="text" class="form-control selectprod" name="prodid[]" required> <option selected disabled value="">Select Product</option> <?php $sql = "SELECT id,name,category,unit,original,selling,quantity,status,timestamp FROM tbl_product ORDER BY timestamp ASC"; $qry = $connection->prepare($sql); $qry->execute(); $qry->bind_result($id,$dbn, $dbc, $dbu,$dbo,$dbs,$dbq,$dbst,$dbtimestamp); $qry->store_result(); while($qry->fetch ()) { echo ' <option value="'.$id.'">'.$dbn.'</option> '; } ?> </select> </td>  <td><input type="number" class="form-control sellprice" required name="selling[]" placeholder="&#8369;0.00" ></td> <td><input type="number" class="form-control quantity" required name="quantity[]" placeholder="Enter Quantity"  ></td> <td><button type="button" class="btn btn-danger btn-sm delprod" ><i class="fa fa-remove"></i></button></td> </tr>');

  });
   $('#tblprod').on('click', '.delprod', function () { 
       $(this).closest('tr').remove();
  });


</script>
<?php 
if(isset($_POST['btnSave'])){

    $sql = "INSERT INTO tbl_stockin(delivery_code,delivery_date,supplier) VALUES(?,?,?)";
    $qry = $connection->prepare($sql);
    $qry->bind_param("sss",$_POST['dcode'],$_POST['ddate'],$_POST['supplier']);

    if($qry->execute()) {

      $last_id = mysqli_insert_id($connection);
      $total = $subtotal = $original = $quantity =  0;
      $prod_arr = count($_POST['prodid']);
      $orig = 0;

      for($i = 0;$i < $prod_arr;$i++){

        $sql = "INSERT INTO tbl_stockin_product(stockin_id,product_id,original,selling,quantity) VALUES(?,?,?,?,?)";
        $qry = $connection->prepare($sql);
        $qry->bind_param('iissi',$last_id,$_POST['prodid'][$i],$orig,$_POST['selling'][$i],$_POST['quantity'][$i]);

        $subtotal = $_POST['selling'][$i] * $_POST['quantity'][$i];

        $total = $total + $subtotal;

        if($qry->execute()){

            $sql = "SELECT quantity FROM tbl_product WHERE id = ?";
            $qry = $connection->prepare($sql);
            $qry->bind_param('i',$_POST['prodid'][$i]);
            $qry->execute();
            $qry->bind_result($dbpquantity);
            $qry->store_result();
            $qry->fetch();

            $dbpquantity = $dbpquantity + $_POST['quantity'][$i];

            $sql = "UPDATE tbl_product SET original=?,selling=?,quantity=? WHERE id=?";
            $qry = $connection->prepare($sql);
            $qry->bind_param("sssi",$_POST['original'][$i],$_POST['selling'][$i],$dbpquantity,$_POST['prodid'][$i]);

            if($qry->execute()) {
              $sql = "UPDATE tbl_stockin SET total=? WHERE id=?";
              $qry = $connection->prepare($sql);
              $qry->bind_param("si",$total,$last_id);

              if($qry->execute()){
                echo '<meta http-equiv="refresh" content="0; URL=index.php?status=created">';
              }

            }
  
        }else{
          echo '<meta http-equiv="refresh" content="0; URL=index.php?status=error">';
        }
      }
      
    }else{
      
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=error">';

    }
}
?>