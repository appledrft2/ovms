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
$pages = 'pet/index';
?>
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
		.heading1{
		color:white;padding:20px;text-align:center;margin:0;background-color:#18BDDB;
		}
	</style>
</head>
<body>
	<h1 class="heading1">Add Breed</h1>
	<div style="display: flex;">
		<div style="flex:1;padding: 10px">
			<form method="POST" action="#">
				<label>Breed <i style="color:red">*</i></label>
				<input type="text" placeholder="Enter Breed" required class="form-control" name="breed">
				<label>Species <i style="color:red">*</i></label>
				<select class="form-control" required name="species" id="species">
				  <option value="" selected disabled>Select Species</option>
				  <option>Canine</option>
				  <option>Feline</option>
				</select>
				<button type="submit" name="btnSubmit" style="margin-top: 5px;float:right" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Add Breed</button>
			</form>
		</div>
		<div style="flex:1;padding: 10px">
			 <table id="table4" class="table table-bordered">
			 	<thead>
			 		<tr>
			 			<th>Name</th>
			 			<th>Type</th>
			 			<th>Action</th>
			 		</tr>
			 	</thead>
			 	<tbody>
			 		<?php 
			 		  $sql = "SELECT id,name,type FROM tbl_pet_breed ORDER BY name ASC";
			 		  $qry = $connection->prepare($sql);
			 		  $qry->execute();
			 		  $qry->bind_result($id,$dbn,$dbt);
			 		  $qry->store_result();
			 		  while($qry->fetch()){
			 		    echo '<tr>
					 			<td>'.$dbn.'</td>
					 			<td>'.$dbt.'</td>';

					 	echo '<td>
					 	  <a href="delete_breed.php?id='.$id.'" ';?>onclick="return confirm('Are you sure?')"<?php echo 'class="btn btn-danger btn-xs" ><i class="fa fa-remove"></i></a></td>';


					 	echo '</tr>';
			 		  }

			 		?>

	
			 	</tbody>
			 	
			 </table>
		</div>
		
	</div>
<?php include('footer.php'); ?>
<?php 

	if(isset($_POST['btnSubmit'])){

		$sql = "INSERT INTO tbl_pet_breed(name,type) VALUES(?,?)";
		$qry = $connection->prepare($sql);
		$qry->bind_param("ss",$_POST['breed'],$_POST['species']);

		if($qry->execute()) {
		  echo '<meta http-equiv="refresh" content="0; URL=breed.php?status=created">';
		}else{
		  echo '<meta http-equiv="refresh" content="0; URL=breed.php?status=error">';
		}

	}

 ?>

