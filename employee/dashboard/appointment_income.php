<?php 

// Order today
$sql2 = "SELECT SUM(total) FROM tbl_appointment WHERE status = 'Completed' AND timestamp >= CURDATE()";
$qry2 = $connection->prepare($sql2);
$qry2->execute();
$qry2->bind_result($a_today);
$qry2->store_result();
$qry2->fetch ();

// Sales this week
$sql2 = "SELECT SUM(total) FROM tbl_appointment WHERE status = 'Completed' AND timestamp BETWEEN DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY) AND NOW()";
$qry2 = $connection->prepare($sql2);
$qry2->execute();
$qry2->bind_result($a_week);
$qry2->store_result();
$qry2->fetch ();
// Sales this month
$sql2 = "SELECT SUM(total) FROM tbl_appointment WHERE status = 'Completed' AND timestamp >= DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE())-1 DAY)";
$qry2 = $connection->prepare($sql2);
$qry2->execute();
$qry2->bind_result($a_month);
$qry2->store_result();
$qry2->fetch ();
// Sales this year
$sql2 = "SELECT SUM(total) FROM tbl_appointment WHERE status = 'Completed' AND YEAR(timestamp) = YEAR(CURDATE())";
$qry2 = $connection->prepare($sql2);
$qry2->execute();
$qry2->bind_result($a_year);
$qry2->store_result();
$qry2->fetch ();


 ?>