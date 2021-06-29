<?php 
session_start();
include('../../../includes/autoload.php');
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
$pages = 'product/index';

if($_GET['keyword'] == ''){
  header('location:index.php');
}
// Custom PHP MySQL Pagination Tutorial and Script
// You have to put your mysql connection data and alter the SQL queries(both queries)

$con = mysqli_connect($host,$user,$pass,$db);
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
//////////////  QUERY THE MEMBER DATA INITIALLY LIKE YOU NORMALLY WOULD
$sql = "SELECT id,name,category,selling,image_path FROM tbl_product WHERE status = 'Available' AND name LIKE '%".$_GET['keyword']."%'";

if ($result=mysqli_query($con,$sql))
    {
    // Return the number of rows in result set
    $nr=mysqli_num_rows($result); // Get total of Num rows from the database query
    }
//////////////////////////////////// Pagination Logic ////////////////////////////////////////////////////////////////////////
if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    //$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
}
//This is where we set how many database items to show on each page
$itemsPerPage = 8;
// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);
// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
}
// This creates the numbers to click in between the next and back buttons
// This section is explained well in the video that accompanies this script
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?keyword='.$_GET['keyword'].'&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?keyword='.$_GET['keyword'].'&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?keyword='.$_GET['keyword'].'&pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?keyword='.$_GET['keyword'].'&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?keyword='.$_GET['keyword'].'&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?keyword='.$_GET['keyword'].'&pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?keyword='.$_GET['keyword'].'&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?keyword='.$_GET['keyword'].'&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
}
// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage;
// Now we are going to run the same query as above but this time add $limit onto the end of the SQL syntax
// $sql2 is what we will use to fuel our while loop statement below
$sql2 = "SELECT id,name,category,selling,image_path FROM tbl_product WHERE status = 'Available' AND name LIKE '%".$_GET['keyword']."%' ORDER BY id ASC $limit";

//////////////////////////////// END Pagination Logic ////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Pagination Display Setup /////////////////////////////////////////////////////////////////////
$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
    // If we are not on page 1 we can place the Back button
    if ($pn != 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  ' &nbsp;  <a class="" href="' . $_SERVER['PHP_SELF'] . '?keyword='.$_GET['keyword'].'&pn=' . $previous . '"> Back</a> ';
    }
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '&nbsp;  <a class="" href="' . $_SERVER['PHP_SELF'] . '?keyword='.$_GET['keyword'].'&pn=' . $nextPage . '"> Next</a> ';
    }
}
///////////////////////////////////// END Pagination Display Setup ///////////////////////////////////////////////////////////////////////////
// Build the Output Section Here
$outputList = '';

$result = mysqli_query($con, $sql2);
if(mysqli_num_rows($result)){
  while($row = mysqli_fetch_array($result)){

      $id = $row["id"];
      $name = $row["name"];
      $category = $row["category"];
      $price = $row["selling"];
      $dbpip = $row['image_path'];
      $prodimg = '';

      if($dbpip == 'images/placeholder.jpg'){
        $prodimg =  "<img src='".$baseurl."employee/dashboard/products/".$dbpip."' style='width:100%;height:200px'>";
      }else{
        $prodimg = "<center><img src='".$baseurl."employee/dashboard/products/".$dbpip."' style='width:200px;height:200px'></center>"; 
      }


      $outputList .= "<div class='col-md-3'>
      <form method='POST' action='#'>
      <div class='box'>
      <div class='box-header'>
      ".$prodimg."
      </div>
      <div class='box-body'>
      <h3>
      ".$name." (".$category.")
      </h3>
      <div class='form-inline'><label>Price:</label>&nbsp;&#8369;".number_format($price,2)."</div>
      <div class='form-inline'><label>Quantity:&nbsp;</label><input type='number' name='pquantity' min='1'  class='form-control' value='1'></div>
      </div>
      <div class='box-footer'>
      <div class='pull-right'>
      <input type='hidden' name='pid' value='".$id."'>
      <button type='submit' name='btnAddCart' class='btn btn-primary '>Add to Cart</button>&nbsp;
      <button type='submit' name='btnBuy' class='btn btn-default '>Buy Now</button>
      </div>
      </div>
      </div>
      </form>
      </div>
      ";
      } // close while loop

}else{
  
  header('location:index.php?result=0');
}



?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
          <h1 class="col-md-6 text-left">
            <span class="text-left">Available Products</span>

          </h1>
          <h2 class="col-md-6 text-right">
            <span class="text-right"><i class="fa fa-calendar"></i> <?php echo date('D, M. d Y') ?></span>
          </h2>
        </div>
      </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-6">
         
       
             
              <div style=" padding:6px; background-color:#FFF; border:#999 1px solid;">
               <form method="GET" action="search.php">
                 <div class="input-group">
                    <input name="keyword" type="text" placeholder="Search Product" class="form-control">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="submit"><i class="fa fa-search"></i> Search</button>
                    </span>
                  </div>
               </form>
               <h4>Search results for: "<?php echo $_GET['keyword']; ?>"</h4>
             </div>

             
         
        
        </div>
        
      </div>

      <br>
      <div class="row">

        
        

       <?php 

       print "$outputList"; 

       if($paginationDisplay != ''){

       ?>

       <div class="col-md-12">
         <div style=" padding:6px; background-color:#FFF; border:#999 1px solid;"><h4 class="text-right"><?php echo $paginationDisplay; ?></h4></div>
       </div>


       <?php 
        }
       ?>
     


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
<script type="text/javascript">
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  
</script>
<?php 
if(isset($_POST['btnAddCart'])){
  $quantity = $_POST['pquantity'];
  $pid = $_POST['pid'];
  $cid = $_SESSION['dbu'];
  $oc = '';

  $sql = "SELECT id,quantity FROM tbl_client_cart WHERE order_code = '' AND client_id = ? AND product_id = ?";
  $qry = $connection->prepare($sql);
  $qry->bind_param('ii',$cid,$pid);
  $qry->execute();
  $qry->bind_result($dbid,$dbq);
  $qry->store_result();
  
  if($qry->fetch()){
    
  $dbq = $dbq + $quantity;  

  $sql2 = "UPDATE tbl_client_cart SET quantity = ? WHERE id = ?";
  $qry2 = $connection->prepare($sql2);
  $qry2->bind_param('ii',$dbq,$dbid);
  $qry2->execute();


  }else{
    
    $sql2 = "INSERT INTO tbl_client_cart(client_id,product_id,quantity,order_code) VALUES(?,?,?,?)";
    $qry2 = $connection->prepare($sql2);
    $qry2->bind_param('iiis',$cid,$pid,$quantity,$oc);
    $qry2->execute();

   

  }
  
 echo "<script>
    Toast.fire({
      icon: 'success',
      title: 'Product Successfully Added'
    })</script>";
 echo '<script>$("#cartcounter").load(location.href + " #cartcounter");</script>';


}if(isset($_POST['btnBuy'])){
  $quantity = $_POST['pquantity'];
  $pid = $_POST['pid'];
  $cid = $_SESSION['dbu'];
  $oc = '';

  $sql = "SELECT id,quantity FROM tbl_client_cart WHERE order_code = '' AND client_id = ? AND product_id = ?";
  $qry = $connection->prepare($sql);
  $qry->bind_param('ii',$cid,$pid);
  $qry->execute();
  $qry->bind_result($dbid,$dbq);
  $qry->store_result();
  
  if($qry->fetch()){
    
  $dbq = $dbq + $quantity;  

  $sql2 = "UPDATE tbl_client_cart SET quantity = ? WHERE id = ?";
  $qry2 = $connection->prepare($sql2);
  $qry2->bind_param('ii',$dbq,$dbid);
  $qry2->execute();


  }else{
    
    $sql2 = "INSERT INTO tbl_client_cart(client_id,product_id,quantity,order_code) VALUES(?,?,?,?)";
    $qry2 = $connection->prepare($sql2);
    $qry2->bind_param('iiis',$cid,$pid,$quantity,$oc);
    $qry2->execute();

   

  }

  echo '<meta http-equiv="refresh" content="0;url=cart.php">';

}


 ?>