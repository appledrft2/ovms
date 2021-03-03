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
$pages ='pos/index';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Point of Sales</span>

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
                    <label>Invoice #: <i style="color:red">*</i></label>
                    <input type="text" class="form-control dcode" value="RC<?php echo rand(199999,299999); ?>" name="icode" required readonly>
                  </div>
                
                </div>
              </div>
              <div class="box-body">

                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Product name</th>
                      <th>Category</th>
                      <th>Unit</th>
                      <th>Price</th>
                      <th>In-stock</th>
                      <th>Quantity</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="tblprod">
                    <tr>
                      <td width="20%">
                        <select type="text" class="form-control selectprod select2" name="prodid[]" style="width: 100%;" required>
                          <option selected disabled value="">Select Product</option>
                           <?php 
                            $sql = "SELECT id,name FROM tbl_product WHERE status = 'Available' ORDER BY timestamp ASC";
                            $qry = $connection->prepare($sql);
                            $qry->execute();
                            $qry->bind_result($id,$dbn);
                            $qry->store_result();
                            while($qry->fetch ()) {
                              echo '
                                <option value="'.$id.'">'.$dbn.'</option>
                               ';
                            }
                          ?>
                        </select>
                      </td>
             
                      <td><input type="text" class="form-control category " name="category[]"  readonly ></td>
                      <td><input type="text" class="form-control unit " name="unit[]"  readonly ></td>
                      <td><input type="text" class="form-control price p0" name="price[]"  readonly ></td>
                      <td><input type="text" class="form-control instock " name="instock[]"  readonly ></td>
                      <td><input type="number" class="form-control quantity q0" name="quantity[]" placeholder="Enter Quantity" required ></td>
                      <td><button type="button" class="btn btn-danger btn-sm" disabled><i class="fa fa-remove"></i></button></td>
                    </tr>
                  </tbody >
                  <tfoot>
                      <tr>
                        <td colspan="7">
                          
                          <div class="pull-right">
                          

                             <button id="moreprod" type="button" class=" btn btn-success btn-sm"><i class="fa fa-plus-circle"></i>&nbsp;Add more</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="7">
                          
                           
                            <div class="pull-right">
                              <label>Total Amount:</label>
                              <input type="number" class="form-control" id="tamount" name="tamount" readonly>
                              <label>Payment:</label>
                              <input type="number" class="form-control" id="payment" name="payment" required>
                              <label>Change:</label>
                              <input type="number" class="form-control" id="change" name="chng" readonly>
                            </div>
                     

                        </td>
                      </tr>
                    
                  </tfoot>
                </table>
              </div>
              <div class="box-footer">
                <div class="pull-right">
                  <button type="submit" name="btnSave" class="btn btn-success"> Process Transaction</button>
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
  var tblcounter = 1;

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
  
      $(this).closest('tr').find('.category').val(proddata[1]);
      $(this).closest('tr').find('.unit').val(proddata[2]);
      $(this).closest('tr').find('.price').val(proddata[3]);
      $(this).closest('tr').find('.instock').val(proddata[4]);
      $(this).closest('tr').find('.quantity').val(1);

      var rowCount = $('#tblprod tr').length;
      var total = subtotal = price = quantity = 0;

      for(i = 0;i < rowCount;i++){
        
        price = $('.p'+i).val();
        quantity = $('.q'+i).val();
        if(quantity == ''){
          quantity = 0;
        }
        subtotal = price * quantity;

        total = total + subtotal;

      }
      $('#tamount').val(total.toFixed(2));

      if($('#payment').val() != ''){
        var change = 0;
        var payment = parseFloat($('#payment').val());
        var tamount = parseFloat($('#tamount').val());
        if(tamount != '' || tamount != 0){

          change = parseFloat(payment) - parseFloat(tamount);

          $('#change').val(change.toFixed(2));

        }else{
          alert('Please add a product first.');
        }
      }
   
  });

  $(document).on('change','.quantity',function(){
    var rowCount = $('#tblprod tr').length;
    var total = subtotal = price = quantity = 0;

    for(i = 0;i < rowCount;i++){
      
      price = $('.p'+i).val();
      quantity = $('.q'+i).val();
      if(quantity == ''){
          quantity = 0;
      }
      subtotal = price * quantity;

      total = total + subtotal;

    }
    $('#tamount').val(total.toFixed(2));

    if($('#payment').val() != ''){
      var change = 0;
      var payment = parseFloat($('#payment').val());
      var tamount = parseFloat($('#tamount').val());
      if(tamount != '' || tamount != 0){

        change = parseFloat(payment) - parseFloat(tamount);

        $('#change').val(change.toFixed(2));

      }else{
        alert('Please add a product first.');
      }
    }

  });
  
  $('#moreprod').click(function(){
    var tblcounter = $('#tblprod tr').length; 
    $("#tblprod").append('<tr> <td width="20%"> <select type="text" class="form-control selectprod select2" name="prodid[]" style="width: 100%;" required> <option selected disabled value="">Select Product</option> <?php $sql = "SELECT id,name FROM tbl_product WHERE status = 'Available' ORDER BY timestamp ASC"; $qry = $connection->prepare($sql); $qry->execute(); $qry->bind_result($id,$dbn); $qry->store_result(); while($qry->fetch ()) { echo ' <option value="'.$id.'">'.$dbn.'</option> '; } ?> </select> </td> <td><input type="text" class="form-control category" name="category[]" readonly ></td> <td><input type="text" class="form-control unit" name="unit[]" readonly ></td> <td><input type="text" class="form-control price p'+tblcounter+'" name="price[]" readonly ></td> <td><input type="text" class="form-control instock" name="instock[]"  readonly ></td><td><input type="number" class="form-control quantity q'+tblcounter+'" name="quantity[]" placeholder="Enter Quantity" required ></td> <td><button type="button" class="btn btn-danger btn-sm delprod" ><i class="fa fa-remove"></i></button></td> </tr>');
      tblcounter++;
    $('.select2').select2();

  });
   $('#tblprod').on('click', '.delprod', function () { 
       $(this).closest('tr').remove();

       var rowCount = $('#tblprod tr').length;
      var total = subtotal = price = quantity = 0;

      for(i = 0;i < rowCount;i++){
        
        price = $('.p'+i).val();
        quantity = $('.q'+i).val();

        if(quantity == ''){
          quantity = 0;
        }
        subtotal = price * quantity;

        total = total + subtotal;
        

      }
      $('#tamount').val(total.toFixed(2));

      if($('#payment').val() != ''){
        var change = 0;
        var payment = parseFloat($('#payment').val());
        var tamount = parseFloat($('#tamount').val());
        if(tamount != '' || tamount != 0){

          change = parseFloat(payment) - parseFloat(tamount);

          $('#change').val(change.toFixed(2));

        }else{
          alert('Please add a product first.');
        }
      }

  });


  $('#payment').keyup(function(){
    var change = 0;
    var payment = parseFloat($(this).val());
    var tamount = parseFloat($('#tamount').val());
    if(tamount != '' || tamount != 0){

      change = parseFloat(payment) - parseFloat(tamount);

      $('#change').val(change.toFixed(2));

    }else{
      alert('Please add a product first.');
    }
  });


});

</script>
<?php 
if(isset($_POST['btnSave'])){


    $sql = "INSERT INTO tbl_stockout(invoicecode,total,payment,chnge) VALUES(?,?,?,?)";
    $qry = $connection->prepare($sql);

    $qry->bind_param("ssss",$_POST['icode'],$_POST['tamount'],$_POST['payment'],$_POST['chng']);

    if($qry->execute()) {

      $last_id = mysqli_insert_id($connection);
      $total = $subtotal = $original = $quantity =  0;
      $prod_arr = count($_POST['prodid']);

      for($i = 0;$i < $prod_arr;$i++){

        $sql = "INSERT INTO tbl_stockout_product(stockout_id,product_id,quantity) VALUES(?,?,?)";
        $qry = $connection->prepare($sql);
        $qry->bind_param('iii',$last_id,$_POST['prodid'][$i],$_POST['quantity'][$i]);

        if($qry->execute()){

            $sql = "SELECT quantity FROM tbl_product WHERE id = ?";
            $qry = $connection->prepare($sql);
            $qry->bind_param('i',$_POST['prodid'][$i]);
            $qry->execute();
            $qry->bind_result($dbpquantity);
            $qry->store_result();
            $qry->fetch();

            $dbpquantity = $dbpquantity - $_POST['quantity'][$i];

            $sql = "UPDATE tbl_product SET quantity=? WHERE id=?";
            $qry = $connection->prepare($sql);
            $qry->bind_param("ii",$dbpquantity,$_POST['prodid'][$i]);

            if($qry->execute()) {
              echo '<meta http-equiv="refresh" content="0; URL=invoice.php?id='.$last_id.'">';
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