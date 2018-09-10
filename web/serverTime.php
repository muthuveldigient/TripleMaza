<?php 
include("include/functions.php");
$row=recordSet("SELECT NOW()");
echo date("M j, Y H:i:s O", strtotime($row[0]));
//$now = new DateTime(); 
//echo $now->format("M j, Y H:i:s O")."\n"; 
?>