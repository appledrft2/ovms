<?php 
if($_SERVER['HTTP_HOST'] == 'localhost'){
	$geturl = 'http://'.$_SERVER['HTTP_HOST'].'/ovms/';
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db = 'ovms';
}else{
	$geturl = 'https://'.$_SERVER['HTTP_HOST'].'/';
	$host = 'us-cdbr-east-03.cleardb.com';
	$user = 'b6b16684e7e7c1';
	$pass = '3484d21d';
	$db = 'heroku_0861a37d9e516ed';
}
$baseurl = $geturl;
$connection = new mysqli($host,$user,$pass,$db);

?>