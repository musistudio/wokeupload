<?php
$con = mysql_connect("localhost","root","1314520wh");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("student", $con);
?>