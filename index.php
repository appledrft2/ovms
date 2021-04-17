<?php include('includes/autoload.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="description">
	<link rel="stylesheet" href="<?php echo $baseurl ?>template/asset/bootstrap.min.css">
	<script src="<?php echo $baseurl ?>template/asset/jquery.min.js"></script>
	<script src="<?php echo $baseurl ?>template/asset/popper.min.js"></script>
	<script src="<?php echo $baseurl ?>template/asset/bootstrap.min.js"></script>

 	  <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/font-awesome/css/font-awesome.min.css">
 	<link rel="shortcut icon" type="image/jpg" href="<?php echo $baseurl ?>template/img/logo.jpg"/>
	<title>Bath & Bark Veterinary Services</title>
	<style type="text/css">
		body{
			font-family: Helvetica !important;
		}
		a:hover{
			color:turquoise;
		}.nav-link{
			color:black;

		}
		.header-nav{
			background-color:#18BDDB;
			height: 60px;
			color:white;
		}
		.text-black{
			color: black!important;
		}
		.text-black:hover{

			color:#18BDDB!important;
		}
		@media screen and (min-width: 0px) and (max-width: 600px) {
		  #home{ display: none; }  
		}
	</style>
</head>
<body >
	<div  id="home" class="header-nav" style="overflow: auto">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-sm-6" style="text-align: left;position: relative;top:20px;left: 20px;">
					  <i class="fa fa-map-marker"></i>

					  Bauan-Batangas Rd, Poblacion 4204 San Pascual, Philippines
				</div>
				<div class="col-md-6 col-sm-6" style="text-align: right;position: relative;top:15px;right: 20px;	">
					 
					 <b>Contact Us <i class="fa fa-mobile-phone"></i> : </b> (+63) 912-345-6789
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid" style="border-bottom: 3px solid grey;border-top: 3px solid grey">
		<nav class="navbar navbar-expand-md bg-light navbar-light" style="background-color: white!important">
		  <a class="navbar-brand" href="<?php echo $baseurl ?>index.php"><img src="<?php echo $baseurl ?>template/img/logo.jpg"  style="width:200px;border-radius:10px;"></a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse navbar-left" id="collapsibleNavbar">
		    <div class="navbar-nav ml-auto" style="font-family: Helvetica;font-size: 1.5em">
		      <div class="nav-item">
		        <a class="nav-link text-black" style="padding:20px"  href="#home">Home</a>
		      </div>
		      <div class="nav-item">
		        <a class="nav-link text-black" style="padding:20px"  href="#aboutus">About Us</a>
		      </div>
		      <div class="nav-item">
		        <a class="nav-link text-black" style="padding:20px"  href="#services">Products & Services</a>
		      </div>
		      <div class="nav-item">
		        <a class="nav-link text-black" style="padding:20px"  href="login.php">Login</a>
		      </div>
		    </div>
		  </div>  
		</nav>
	</div>
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
	 
	  <div class="carousel-inner">
	    <div class="carousel-item active">
	      <img src="<?php echo $baseurl ?>template/img/banner.png" class="d-block img-fluid w-100" style="height: 550px;" alt="...">
	      
	    </div>
	    
	      
	   
	  </div>
	
	</div>

	<div id="aboutus" style="border-top:3px solid grey;border-bottom:3px solid grey;background-color:#18BDDB;padding:5px; ">
		<h1 style="text-align:center;color:white">
			ABOUT US
		</h1>
	</div>
	
		<div class="aboutus"  style="background-image: url('<?php echo $baseurl ?>template/img/aboutbg.jpg');height: 600px;overflow:auto">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6" style="text-align: center">
						<div class="box ">
							<img src="<?php echo $baseurl ?>template/img/77.jpg" style="margin-top:100px;width:100%;height: 300px;border:2px solid black;border-radius: 15px;">
						</div>
					</div>
					<div class="col-md-6" style="text-align: center">
						<div class="box " style="margin-top:100px;border:2px solid black;padding:20px;border-radius: 10px;background-color: white">
							<div class="box-header">
								<h4 style="text-align: left">What We Offer</h4>
							</div>
							<div class="box-body text-justify mt-3">
								<p>
									The Bath & Bark Grooming and Veterinary Services, We aim to provide not only sound advice but also excellent veterinary treatment, enabling you to enjoy your companion for as long as possible. It is not only our duty to handle your pet when he or she is ill, but it is also our job to teach you how to keep your best friend happy and safe.
									<br><br>When choosing a veterinarian, It's crucial to consider all aspects of the clinic's services. Compassion, affordability, and consistency are all essential characteristics, but we strive to provide treatment that surpasses all standards.
								</p>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
	<div id="services" style="border-top:3px solid grey;border-bottom:3px solid grey;background-color:#18BDDB;padding:5px; ">
		<h1 style="text-align:center;color:white">
			PRODUCTS AND SERVICES OFFERED
		</h1>
	</div>
	<div class="services" id="prod" >
		<div class="box mt-5" style="padding:20px;border-radius: 10px;background-color: white">
			<div class="box-header">
				<h4>SERVICES</h4>
			</div>
			<div class="box-body text-justify">
				<div class="row">
					<?php
					// 
					  $per_page = 4;
					// 
					  $count_service = "SELECT count(*) FROM tbl_service";
					  $qry1 = $connection->prepare($count_service);
					  $qry1->execute();
					  $qry1->bind_result($dbcs);
					  $qry1->store_result();
					  $qry1->fetch();
					// 
					  $db_length = $dbcs;
					  $number_of_pages = ceil($db_length / $per_page);

					//
					if(!isset($_GET['spage'])){
						$page = 1;
						$page1 = 1;
					}else{
						if(is_numeric($_GET['spage'])){
							$page = $_GET['spage'];
							$page1 = $_GET['spage'];
						}else{
							$page = 1;
							$page1 = 1;
						}

					}
					//
					$this_page_first_result = ($page-1)*$per_page;
					//
					$sql2 = "SELECT id,name FROM tbl_service LIMIT ?,?";
					$qry2 = $connection->prepare($sql2);
					$qry2->bind_param("ii",$this_page_first_result,$per_page);
					$qry2->execute();
					$qry2->bind_result($dbsid,$dbsn);
					$qry2->store_result();
					while ($qry2->fetch()) {
						echo "<div class='col-md-3'>";
						echo "<div class='box'>";
						echo "<div class='box-header'>";
						echo "<img src='".$baseurl."template/img/banner.png' style='width:100%;'>";
						echo "</div>";
						echo "<div class='box-body'>";
						echo '<h4>'.$dbsn.'</h4>';
						echo "</div>";
						echo "</div>";
						echo "</div>";

					}
					?>
				</div>
				<div class="box  mt-5" style="float:right">
					<?php 

					echo '<nav aria-label="Page navigation example">
						  <ul class="pagination">';

					$prev = $page1 - 1;
					if($prev == 0){
						echo '<li class="page-item disabled"><a class="page-link" href="index.php?spage='.$prev.'#services">Previous</a></li>';
					}else{
						echo '<li class="page-item "><a class="page-link" href="index.php?spage='.$prev.'#services">Previous</a></li>';
					} 
					for($page=1;$page <= $number_of_pages;$page++){
					
					if($page == $page1){
						echo '<li class="page-item active"><a class="page-link" href="index.php?spage='.$page.'#services">'.$page.'</a></li>';
					}else{
						echo '<li class="page-item"><a class="page-link"  href="index.php?spage='.$page.'#services">'.$page.'</a></li>';
					}

					}
					$next = $page1 + 1;  
					if($next > $number_of_pages){
						echo '<li class="page-item disabled"><a class="page-link" href="index.php?spage='.$next.'">Next</a></li>
							';
					}else{
						echo '<li class="page-item "><a class="page-link" href="index.php?spage='.$next.'#services">Next</a></li>
							';
					}
					echo	'</ul></nav>'; 

					?>
				</div>
			</div>
		</div>
		<div id="products" class="box mt-5" style="padding:20px;border-radius: 10px;background-color: white;margin-bottom: 100px;">
			<div class="box-header">
				<h4>PRODUCTS</h4>
			</div>
			<div class="box-body text-justify">
							<div class="row">
								<?php
								// 
								  $per_page = 4;
								// 
								  $count_service = "SELECT count(*) FROM tbl_product";
								  $qry1 = $connection->prepare($count_service);
								  $qry1->execute();
								  $qry1->bind_result($dbcs);
								  $qry1->store_result();
								  $qry1->fetch();
								// 
								  $db_length = $dbcs;
								  $number_of_pages = ceil($db_length / $per_page);

								//
								if(!isset($_GET['ppage'])){
									$page = 1;
									$page1 = 1;
								}else{
									if(is_numeric($_GET['ppage'])){
										$page = $_GET['ppage'];
										$page1 = $_GET['ppage'];
									}else{
										$page = 1;
										$page1 = 1;
									}

								}
								//
								$this_page_first_result = ($page-1)*$per_page;
								//
								$sql2 = "SELECT id,name FROM tbl_product LIMIT ?,?";
								$qry2 = $connection->prepare($sql2);
								$qry2->bind_param("ii",$this_page_first_result,$per_page);
								$qry2->execute();
								$qry2->bind_result($dbsid,$dbsn);
								$qry2->store_result();
								while ($qry2->fetch()) {
									echo "<div class='col-md-3'>";
									echo "<div class='box'>";
									echo "<div class='box-header'>";
									echo "<img src='".$baseurl."template/img/banner.png' style='width:100%;'>";
									echo "</div>";
									echo "<div class='box-body'>";
									echo '<h4>'.$dbsn.'</h4>';
									echo "</div>";
									echo "</div>";
									echo "</div>";

								}
								?>
							</div>
							<div class="box  mt-5" style="float:right">
								<?php 

								echo '<nav aria-label="Page navigation example">
									  <ul class="pagination">';

								$prev = $page1 - 1;
								if($prev == 0){
									echo '<li class="page-item disabled"><a class="page-link" href="index.php?ppage='.$prev.'#prod">Previous</a></li>';
								}else{
									echo '<li class="page-item "><a class="page-link" href="index.php?ppage='.$prev.'#prod">Previous</a></li>';
								} 
								for($page=1;$page <= $number_of_pages;$page++){
								
								if($page == $page1){
									echo '<li class="page-item active"><a class="page-link" href="index.php?ppage='.$page.'#prod">'.$page.'</a></li>';
								}else{
									echo '<li class="page-item"><a class="page-link"  href="index.php?ppage='.$page.'#prod">'.$page.'</a></li>';
								}

								}
								$next = $page1 + 1;  
								if($next > $number_of_pages){
									echo '<li class="page-item disabled"><a class="page-link" href="index.php?ppage='.$next.'">Next</a></li>
										';
								}else{
									echo '<li class="page-item "><a class="page-link" href="index.php?ppage='.$next.'#prod">Next</a></li>
										';
								}
								echo	'</ul></nav>'; 

								?>
							</div>
						</div>
		</div>
	</div>
	<div id="contact" style="border-top:3px solid grey;border-bottom:3px solid grey;background-color:#18BDDB;padding:5px;height: 50px ">			
	</div>
	<div class="contact" style="width: 100%;height: 500px">
		
	</div>
	

</body>
</html>