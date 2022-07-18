<?php
error_reporting(0);
$host="";
$username="";
$password="";
$db_name=""; 

mysql_connect("$host", "$username", "$password")or die("cannot connect to server");
mysql_select_db("$db_name")or die("cannot select db");
 

?>