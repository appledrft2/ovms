<?php 
session_start();

include('includes/autoload.php'); ?>
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
	<title>Bath & Bark Grooming & Veterinary Services</title>
	<style type="text/css">
		@-webkit-keyframes fade {
		  0%   { opacity: 0; }
		  100% { opacity: 1; }
		}
		@-moz-keyframes fade {
		  0%   { opacity: 0; }
		  100% { opacity: 1; }
		}
		@-o-keyframes fade {
		  0%   { opacity: 0; }
		  100% { opacity: 1; }
		}
		@keyframes fade {
		  0%   { opacity: 0; }
		  100% { opacity: 1; }
		}

		body{
			font-family: Helvetica !important;
			animation-name: fade;
			animation-duration: 0.5s; 
			animation-fill-mode: forwards;
			scroll-behavior: smooth !important; 
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
		.center {
		  display: block;
		  margin-left: auto;
		  margin-right: auto;
		  width: 50%;
		}#contactflex{
		  	display:flex;
		 } 
		@media screen and (min-width: 0px) and (max-width: 600px) {
		  #home{ display: none; }
		  #contactflex{
		  	 flex-direction: column;
		  } 
		  #contact2{order:1;} 
		  #businesshours{order:2;}
		}
		#myBtn {
		  display: none; /* Hidden by default */
		  position: fixed; /* Fixed/sticky position */
		  bottom: 20px; /* Place the button at the bottom of the page */
		  right: 30px; /* Place the button 30px from the right */
		  z-index: 99; /* Make sure it does not overlap */
		  border: none; /* Remove borders */
		  outline: none; /* Remove outline */
		  background-color: #18BDDB; /* Set a background color */
		  color: white; /* Text color */
		  cursor: pointer; /* Add a mouse pointer on hover */
		  padding: 15px; /* Some padding */
		  border-radius: 10px; /* Rounded corners */
		  font-size: 18px; /* Increase font size */
		  border:1px solid white;
		}

		#myBtn:hover {
		  background-color: #18BDDB; /* Add a dark-grey background on hover */
		}
	
	</style>
</head>
<body>
	<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
	<div  id="home" class="header-nav" style="overflow: auto">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-sm-6" style="text-align: left;position: relative;top:20px;left: 20px;">
					  <i class="fa fa-map-marker"></i>

					  Bauan-Batangas Rd, Poblacion 4204 San Pascual, Philippines
				</div>
				<div class="col-md-6 col-sm-6" style="text-align: right;position: relative;top:15px;right: 20px;	">
					 
					 <b>Contact Us <i class="fa fa-mobile-phone"></i> : </b> (+63) 943-882-7552
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
		        <?php if(isset($_SESSION['dbu'])) : ?>
		        <a class="nav-link text-black" style="padding:20px"  href="login.php">Dashboard</a>
		        <?php else : ?>
		        <a class="nav-link text-black" style="padding:20px"  href="login.php">Login</a>
		        <?php endif; ?>
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
							<img src="<?php echo $baseurl ?>template/img/88.jpg" style="margin-top:100px;width:100%;height: 300px;border:2px solid black;border-radius: 15px;">
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

		<div id="products" class="box mt-5" style="padding:20px;border-radius: 10px;background-color: white;margin-bottom: 100px;">
			<div class="box-header">
				<h3>PRODUCTS</h3>
			</div>
			<div class="box-body text-justify">
							<div class="row">
								<?php
								// 
								  $per_page = 8;
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
								$sql2 = "SELECT id,name,category,selling,image_path FROM tbl_product WHERE status = 'Available' ORDER BY name ASC LIMIT ?,?";
								$qry2 = $connection->prepare($sql2);
								$qry2->bind_param("ii",$this_page_first_result,$per_page);
								$qry2->execute();
								$qry2->bind_result($dbpid,$dbpn,$dbpc,$dbpp,$dbpip);
								$qry2->store_result();
								while ($qry2->fetch()) {
									echo "<div class='col-md-3' style='margin-bottom:10px;'>";
									echo "<div class='card'>";
									echo "<div class='box-header' style='text-align:center'>";
									if($dbpip == 'images/placeholder.jpg'){
										echo "<img src='".$baseurl."employee/dashboard/products/".$dbpip."' style='width:100%;height:200px'>";
									}else{
										echo "<img src='".$baseurl."employee/dashboard/products/".$dbpip."' style='width:200px;height:200px'>";	
									}

									echo "</div>";
									echo "<div class='card-body'>";
									echo "<h4>".$dbpn." (".$dbpc.")</h4>";
									echo "<div class='form-inline'><label>Price:</label>&nbsp;&#8369;".number_format($dbpp,2)."</div>";
									echo "</div>";
									echo "<div class='card-footer'>";
									echo "<button type='submit' name='btnAddCart' class='btn' style='background-color:#18BDDB;color:white;float:right'><a href='login.php' style='text-decoration:none;color:white'><i class='fa fa-shopping-cart'></i> Add to Cart</a></button>";
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
		<div class="box mt-5" style="padding:20px;border-radius: 10px;background-color: white">
			<div class="box-header">
				<h3>SERVICES</h3>
			</div>
			<div class="box-body text-justify">
				<div class="row">
					<?php
					// 
					  $per_page = 8;
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
					$sql2 = "SELECT id,name,price,image_path FROM tbl_service ORDER BY name ASC LIMIT ?,?";
					$qry2 = $connection->prepare($sql2);
					$qry2->bind_param("ii",$this_page_first_result,$per_page);
					$qry2->execute();
					$qry2->bind_result($dbsid,$dbsn,$dbsp,$dbip);
					$qry2->store_result();
					while ($qry2->fetch()) {
						
						if($dbip == ''){
							$dbip = 'images/placeholder.jpg';
						}
						echo "<div class='col-md-3' style='margin-bottom:10px;'>";

						echo "<div class='card'>";
						echo "<div class='box-header' style='text-align:center'>";
						echo "<img src='".$baseurl."employee/dashboard/services/".$dbip."' style='width:100%;height:200px;'>";
						echo "</div>";
						echo "<div class='card-body'>";
						echo "<h4>".$dbsn."</h4>";
						echo "<div class='form-inline'><label>Price:</label>&nbsp;&#8369;".number_format($dbsp,2)."</div>";
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
	</div>
	<div id="contact" style="margin-top:100px;border-top:3px solid grey;border-bottom:3px solid grey;background-color:#18BDDB;padding:5px;height: 50px ">			
	</div>
	<div class="contact" style="width: 100%;">
		<div id="contactflex" class="mt-5">
			<div class="col-md-6" id="contact2">
				<img src="<?php echo $baseurl ?>template/img/logo.jpg" class="center mt-5" style="border-radius:10px;">
				<hr>
				<div style="display:flex;">
					<div class="" style="margin-right: 10px;">
						<i class="fa fa-map-marker" style="font-size: 3em;"></i>
					</div>
					<div class="">
						<p class="text-justify">Bath & Bark Grooming and Veterinary<br>
						Bauan-Batangas Rd, Poblacion 4204 San Pascual, Philippines</p>
					</div>
				</div>
				<div style="display:flex;">
					<div class="" style="margin-right: 10px;">
						<i class="fa fa-phone" style="font-size: 3em;"></i>
					</div>
					<div class="">
						<p class="text-justify mt-3">+639438827552
						</p>
					</div>
				</div>


			</div>
			<div class="col-md-6" id="businesshours" style="align-items: center;text-align: center">
				<h2 style="margin-top:10px;">BUSINESS HOURS</h2>
				<table class="table table-bordered">
					<tr>
						<td>
							Monday
						</td>
						<td>
							8:00AM - 6:00PM
						</td>
					</tr>
					<tr>
						<td>
							Tuesday
						</td>
						<td>
							8:00AM - 6:00PM
						</td>
					</tr>
					<tr>
						<td>
							Wednesday
						</td>
						<td>
							8:00AM - 6:00PM
						</td>
					</tr>
					<tr>
						<td>
							Thursday
						</td>
						<td>
							8:00AM - 6:00PM
						</td>
					</tr>
					<tr>
						<td>
							Friday
						</td>
						<td>
							8:00AM - 6:00PM
						</td>
					</tr>
					<tr>
						<td>
							Saturday
						</td>
						<td>
							8:00AM - 6:00PM
						</td>
					</tr>
					<tr>
						<td>
							Sunday
						</td>
						<td>
							8:00AM - 6:00PM
						</td>
					</tr>
					
				</table>
			</div>
		</div>
	</div>
	<div id="footer" style="margin-top:50px;border-top:3px solid grey;background-color:#18BDDB;padding:5px; ">
	<h5 style="text-align: center;color:white">Copyright 	&#169; 2021 <a href="#" style="text-decoration: none;color:white">Bath & Bark Grooming & Veterinary Services.</a></h5>			
	</div>

</body>
</html>
<script type="text/javascript">
	//Get the button:
	mybutton = document.getElementById("myBtn");

	// When the user scrolls down 20px from the top of the document, show the button
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
	    mybutton.style.display = "block";
	  } else {
	    mybutton.style.display = "none";
	  }
	}

	// When the user clicks on the button, scroll to the top of the document
	function topFunction() {
	  document.body.scrollTop = 0; // For Safari
	  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
	}
</script>