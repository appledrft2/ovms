<?php 
$geturl = ($_SERVER['HTTP_HOST'] == 'localhost' ? 'http://'.$_SERVER['HTTP_HOST'].'/ovms/' : 'https://'.$_SERVER['HTTP_HOST'].'/');
$baseurl = $geturl;
$connection = new mysqli('localhost','root','','ovms');

?>