<?php 

// Sales today
$sql = "SELECT SUM(total) FROM tbl_stockout WHERE timestamp >= CURDATE()";
$qry = $connection->prepare($sql);
$qry->execute();
$qry->bind_result($today);
$qry->store_result();
$qry->fetch ();
// Sales this week
$sql = "SELECT SUM(total) FROM tbl_stockout WHERE timestamp BETWEEN DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY) AND NOW()";
$qry = $connection->prepare($sql);
$qry->execute();
$qry->bind_result($week);
$qry->store_result();
$qry->fetch ();
// Sales this month
$sql = "SELECT SUM(total) FROM tbl_stockout WHERE timestamp >= DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE())-1 DAY)";
$qry = $connection->prepare($sql);
$qry->execute();
$qry->bind_result($month);
$qry->store_result();
$qry->fetch ();
// Sales this year
$sql = "SELECT SUM(total) FROM tbl_stockout WHERE YEAR(timestamp) = YEAR(CURDATE())";
$qry = $connection->prepare($sql);
$qry->execute();
$qry->bind_result($year);
$qry->store_result();
$qry->fetch ();


 ?>