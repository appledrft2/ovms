<?php 
$geturl = ($_SERVER['HTTP_HOST'] == 'localhost' ? $_SERVER['HTTP_HOST'].'/ovms/' : $_SERVER['HTTP_HOST']);
$baseurl = 'http://'.$geturl;
$connection = new mysqli('localhost','root','','ovms');

?>