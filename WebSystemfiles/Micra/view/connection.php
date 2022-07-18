<?php
	//for MySQLi OOP
	
/* Database connection start */
$servername = "localhost";
$username = "id18437919_micradb";
$password = "Micradbthesis2@";
$dbname = "id18437919_micra";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}