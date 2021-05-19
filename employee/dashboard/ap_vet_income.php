<?php 

// Order today
$sql2 = "SELECT SUM(total) FROM tbl_appointment WHERE status = 'Completed' AND veterinarian_id = ? AND timestamp >= CURDATE()";
$qry2 = $connection->prepare($sql2);
$qry2->bind_param('i',$_SESSION['dbu']);
$qry2->execute();
$qry2->bind_result($v_today);
$qry2->store_result();
$qry2->fetch ();

// Sales this week
$sql2 = "SELECT SUM(total) FROM tbl_appointment WHERE status = 'Completed' AND veterinarian_id = ? AND timestamp BETWEEN DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY) AND NOW()";
$qry2 = $connection->prepare($sql2);
$qry2->bind_param('i',$_SESSION['dbu']);
$qry2->execute();
$qry2->bind_result($v_week);
$qry2->store_result();
$qry2->fetch ();
// Sales this month
$sql2 = "SELECT SUM(total) FROM tbl_appointment WHERE status = 'Completed' AND veterinarian_id = ? AND timestamp >= DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE())-1 DAY)";
$qry2 = $connection->prepare($sql2);
$qry2->bind_param('i',$_SESSION['dbu']);
$qry2->execute();
$qry2->bind_result($v_month);
$qry2->store_result();
$qry2->fetch ();
// Sales this year
$sql2 = "SELECT SUM(total) FROM tbl_appointment WHERE status = 'Completed' AND veterinarian_id = ? AND YEAR(timestamp) = YEAR(CURDATE())";
$qry2 = $connection->prepare($sql2);
$qry2->bind_param('i',$_SESSION['dbu']);
$qry2->execute();
$qry2->bind_result($v_year);
$qry2->store_result();
$qry2->fetch ();


 ?>